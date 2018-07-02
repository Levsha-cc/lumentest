<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class PDB
 * Предоставляет выборку из БД, инфо по таблицам, осуществляет импорт данных
 * @package App
 *
 */
class PDB extends Model
{
    private $tables = ['users', 'story'];

    /**
     * Импортирует логи в БД
     * @return $this
     */
    public function importLogs()
    {
        // данные о текущих логах
        $logs = (new Logs)->info();

        // очищаем обе таблицы
        foreach ($this->tables as $name) {
            DB::statement("TRUNCATE {$name} CASCADE");
        }

        // считываем файлы как CSV и построчно пишеи в БД
        foreach ($this->tables as $name) {
            $file = fopen($logs[$name]['path'], "r");
            while ( ($data = fgetcsv($file, 2000, "|")) !==FALSE) {

                $insert = [];
                // ассоциации для пользователей
                if ($name == 'users') {
                    $insert = [
                        'ip' => trim($data[0]),
                        'browser' => trim($data[1]),
                        'os' => trim($data[2])
                    ];
                }

                // ассоциации для истории
                if ($name == 'story') {
                    $insert = [
                        'date' => trim($data[0] . ' ' . $data[1]),
                        'ip' => trim($data[2]),
                        'url_from' => trim($data[3]),
                        'url_to' => trim($data[4])
                    ];
                }

                DB::table($name)->insert($insert);
            }
            fclose($file);
        }

        return $this;
    }

    /**
     * Возвращает массив таблиц, где ключом является имя таблицы, а значением колво записей в таблице
     * @return array
     */
    public function dbInfo()
    {
        $data = [];
        foreach ($this->tables as $name) {
            $data[$name] = DB::table($name)->count();
        }
        return $data;
    }

    /**
     * Выбираем нужные данные для таблицы одним запросом
     * @param int $limit
     * @param int $offset
     * @return mixed
     */
    public function tableData($limit = 0, $offset = 0)
    {
        $query_limit = '';
        if (($limit = (int)$limit) && $limit > 0) {
            $query_limit = " LIMIT {$limit} ";
        }
        if ($query_limit && ($offset = (int)$offset) && $offset > 0) {
            $query_limit .= " OFFSET {$offset} ";
        }

        $result = DB::select("
            SELECT distinct on (users.ip) 
              users.ip, users.browser, users.os, story.url_from, lastStory.url_to, 
              COUNT(*) over(partition by story.ip order by story.date)
            FROM users 
            LEFT JOIN story ON users.ip = story.ip
            LEFT JOIN story as lastStory ON users.ip = lastStory.ip
            order by users.ip, story.date ASC, lastStory DESC
            {$query_limit}
            ");

        return $result;
    }


}
