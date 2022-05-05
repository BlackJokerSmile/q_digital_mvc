<?php
    $cfg = parse_ini_file('./config/migration.cfg');

    function connectDB()
    {
        global $cfg;

        $errorMessage = 'Невозможно подключиться к серверу базы данных';
        
        $conn = new mysqli(
            $cfg['HOST'],
            $cfg['DB_USER'],
            $cfg['DB_PASSWORD'],
            $cfg['DB_NAME']
        );

        if (!$conn)
            throw new Exception($errorMessage);
        else {
            $query = $conn->query('set names utf8');
            if (!$query)
                throw new Exception($errorMessage);
            else
                return $conn;
    }
    }

    function getMigrationFiles($conn)
    {
        global $cfg;

        $currentDir = str_replace('\\', '/', realpath(dirname(__FILE__)) . '/');
        $migrationsDir = $currentDir . $cfg['MIGRATIONS_DIR']. '/';

        $allFiles = glob($migrationsDir . '*.sql');

        $query = sprintf('show tables from `%s` like "%s"',
            $cfg['DB_NAME'],
            $cfg['DB_TABLE_VERSIONS']
        );
        $data = $conn->query($query);
        $isFirstMigration = !$data->num_rows;
        
        if ($isFirstMigration) {
            return $allFiles;
        }

        $versionsFiles = array();
        
        $query = sprintf('select `name` from `%s`', $cfg['DB_TABLE_VERSIONS']);
        $data = $conn->query($query)->fetch_all(MYSQLI_ASSOC);

        foreach ($data as $row) {
            array_push($versionsFiles, $migrationsDir . $row['name']);
        }

        return array_diff($allFiles, $versionsFiles);
    }

    function migrate($conn, $file)
    {
        global $cfg;

        $command = sprintf('mysql -u%s -p%s -h %s -D %s < %s',
            $cfg['DB_USER'],
            $cfg['DB_PASSWORD'],
            $cfg['HOST'],
            $cfg['DB_NAME'],
            $file
        );    

        $baseName = basename($file);

        exec($command, $command_output, $command_status);
        
        // If status code is 0 => success, else error
        if ($command_status) die('Не удалось записать версию миграции в базу данных: '.$baseName);

        $query = sprintf('INSERT INTO `%s` (`name`) VALUES("%s");', $cfg['DB_TABLE_VERSIONS'], $baseName);

        $conn->query($query);
    }
    
    $conn = connectDB();

    $files = getMigrationFiles($conn);

    if (empty($files)) {
        echo 'Ваша база данных в актуальном состоянии.';
    } else {
        echo 'Начинаем миграцию...'.PHP_EOL;    

        foreach ($files as $file) {
            migrate($conn, $file);
            echo basename($file).PHP_EOL;
        }

        echo 'Миграция завершена.'; 
    }
