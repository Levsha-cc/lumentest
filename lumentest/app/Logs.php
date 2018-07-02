<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class Logs
 * Предоставляет доступ к логам, генерирует случайные логи, импортирует логи в БД
 * @package App
 *
 */
class Logs extends Model
{
    public $browsers = [
        'Safari 9',
        'Chrome 63',
        'Firefox 56',
        'Internet Explorer 9',
        'Opera 43',
        'Internet Explorer 11'
    ];
    public $os = [
        'iOS',
        'Windows',
        'macOS',
        'Android',
        'Mac OS X'
    ];
    public $word = [
        ['create', 'remove', 'update', 'delete', 'copy', 'select', 'insert', 'get', 'put', 'post', 'add', 'post'],
        ['event', 'blog', 'gallery', 'commentary', 'page', 'block'],
        ['wordpress', 'website', 'shopify', 'google', 'facebook', 'twitter']
    ];
    public $time;

    public $log_users = 'users.log';
    public $log_story = 'story.log';

    public function __construct()
    {
        $this->time = time();

        $logs = ['users', 'story'];
        foreach ($logs as $name) {
            if (!file_exists($this->path($name))) file_put_contents($this->path($name) , '');
        }
    }


    /**
     * Возвращает полный путь к лог файлу
     * @param $name
     * @return string
     */
    public function path($name)
    {
        return base_path('public') . '/' .
            (($name == 'users') ? $this->log_users : $this->log_story );
    }


    /**
     * Для генератора - Генерирует рандомный IP
     * @return string
     */
    private function randomIP()
    {
        return (string)rand(1,255).'.'.(string)rand(1,255).'.'.(string)rand(1,255).'.'.(string)rand(1,255);
    }

    /**
     * Для генератора - Возвращает рандоную ОС
     * @return string
     */
    private function randomOS()
    {
        return array_random($this->os);
    }

    /**
     * Для генератора - Возвращает рандомный браузер
     * @return string
     */
    private function randomBrowser()
    {
        return array_random($this->browsers);
    }

    /**
     * Для генератора - Создает рандомных пользователей с IP, ОС и Браузером
     * @param int $countUsers
     * @return array
     */
    private function randomUsers($countUsers = 0)
    {
        $users = [];
        $countUsers = $countUsers ? $countUsers : rand(50,100);

        for ($i=0; $i <= $countUsers ; $i++) {
            $ip = $this->randomIP();
            $users[$ip] = [
                'ip' => $ip,
                'os' => $this->randomOS(),
                'browser' => $this->randomBrowser()
            ];
        }

        return $users;
    }

    /**
     * Для генератора - Создает рандомную историю для уже созданных пользователей
     * @param $users
     * @return array
     */
    private function randomStory($users)
    {
        $story = [];

        foreach ($users as $ip => $user) {
            $events = rand(1, 10);
            for ($i = 0; $i < $events; $i++) {
                $time = $this->newTime();
                $story[$time] = [
                    'date' => date('Y-m-d', $time),
                    'time' => date('H:i:s', $time),
                    'ip' => $ip,
                    'url_from' => $this->randomUrl(),
                    'url_to' => $this->randomUrl(),
                ];
            }
        }

        return $story;
    }

    /**
     * Для генератора - Добавляет ко времени 4 минуты
     * @return int
     */
    private function newTime()
    {
        return $this->time = strtotime('+4 minutes', $this->time);
    }


    /**
     * Для генератора - генерирует рандомный URL
     * @return string
     */
    private function randomUrl()
    {
        return '/'. array_random($this->word[0]) .
            ucfirst(array_random($this->word[1])) .
            ucfirst(array_random($this->word[2])) ;
    }

    /**
     * Генераторириует логи и пишет в файлы
     * @param int $countUsers
     * @return $this
     */
    public function generateLogs($countUsers = 0)
    {
        $users = $this->randomUsers($countUsers);
        $story = $this->randomStory($users);

        $users_log = $this->path('users');
        $story_log = $this->path('story');

        file_put_contents($users_log, '');
        file_put_contents($story_log, '');

        foreach ($users as $data) {
            file_put_contents($users_log, "{$data['ip']}|{$data['browser']}|{$data['os']}\r\n", FILE_APPEND);
        }
        foreach ($story as $data) {
            file_put_contents($story_log,
                "{$data['date']}|{$data['time']}|{$data['ip']}|{$data['url_from']}|{$data['url_to']}\r\n",
                FILE_APPEND);
        }

        return $this;
    }


    /**
     * Возвращает информацию о текущих логах
     * @return array
     */
    public function info()
    {
        $logs = ['users' => [], 'story' => []];
        foreach ($logs as $name => $log) {
            $logs[$name] = [
                'path' => $this->path($name),
                'size' => file_exists($this->path($name)) ? strlen(file_get_contents($this->path($name))) : 0
            ];
        }
        return $logs;
    }

}
