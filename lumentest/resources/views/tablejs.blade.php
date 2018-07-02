@extends('layout')

@section('content')
    <script>
        Ext.define('Users', {
            extend: 'Ext.data.Model',
            fields: [ 'ip', 'browser', 'os', 'url_from', 'url_to', 'count' ]
        });

        var userStore = Ext.create('Ext.data.Store', {
            model: 'Users',
            autoLoad: true,
            pageSize: 25,
            proxy: {
                type: 'ajax',
                url : '/tablejs/json',
                reader: {
                    type: 'json',
                    root: 'data',
                    totalProperty: 'total'
                }
            }
        });

        Ext.create('Ext.grid.Panel', {
            renderTo: document.body,
            store: userStore,
            width: 800,
            height: 625,
            title: 'UsersStory',
            columns: [
                {
                    text: 'IP',
                    width: 120,
                    sortable: false,
                    hideable: false,
                    dataIndex: 'ip'
                },
                {
                    text: 'Browser',
                    width: 150,
                    sortable: true,
                    dataIndex: 'browser'
                },
                {
                    text: 'OS',
                    flex: 1,
                    sortable: true,
                    dataIndex: 'os'
                },
                {
                    text: 'URL From',
                    flex: 1,
                    sortable: false,
                    dataIndex: 'url_from'
                },
                {
                    text: 'URL To',
                    flex: 1,
                    sortable: false,
                    dataIndex: 'url_to'
                },
                {
                    text: 'Кол-во визитов',
                    flex: 1,
                    sortable: false,
                    dataIndex: 'count'
                }
            ],
            dockedItems: [{
                xtype: 'pagingtoolbar',
                store: userStore,   // same store GridPanel is using
                dock: 'bottom',
                displayInfo: true
            }]

        });

    </script>

    <h3>Таблица ExtJS:</h3>


@endsection
