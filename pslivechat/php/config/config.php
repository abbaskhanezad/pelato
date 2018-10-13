<?php

$config = array(

    // Database settings
    
    'dbHost'          => '127.0.0.1',
    'dbPort'          => 3306,
    'dbUser'          => 'pelatoir_panel',
    'dbPassword'      => 'ETuFmLH5042akaf8',
    'dbName'          => 'pelatoir_panel',
    
    // Chat application admin user
    
    'superUser' => 'admin',
    'superPass' => 'pelato',
    
    // Other (do not modify manually)

    'dbType' => 'mysql',
    
    'avatarImageSize' => 40,
    
    'defaultSettings' => array(
    
        'primaryColor'          => '#36a9e1',
        'secondaryColor'        => '#86C953',
        'labelColor'            => '#ffffff',
        'hideWhenOffline'       => true,
        'contactMail'           => 'admin@domain.com',
        'loadingLabel'          => 'در حال بارگزاری...',
        'loginError'            => 'قادر به ورود نیستید',
        'chatHeader'            => '    گفتگوی زنده با پشتیبانی پلاتو',
        'startInfo'             => 'برای شروع گفتگو با واحد پشتیبانی ، لطفا فیلد های زیر را تکمیل کنید',
        'maxConnections'        => 5,
        'messageSound'          => 'audio/default.mp3',
        'startLabel'            => 'شروع',
        'backLabel'             => 'بازگشت',
        'initMessageBody'       => 'سلام ، می توانم به شما کمک کنم؟',
        'initMessageAuthor'     => 'اپراتور',
        'chatInputLabel'        => 'پرسش خود را بنویسید',
        'timeDaysAgo'           => 'روز قبل',
        'timeHoursAgo'          => 'ساعت قبل',
        'timeMinutesAgo'        => 'دقیقه قبل',
        'timeSecondsAgo'        => 'ثانیه قبل',
        'offlineMessage'        => 'اپراتور آفلاین شد.',
        'toggleSoundLabel'      => 'افکت صوتی',
        'toggleScrollLabel'     => 'اسکرول اتوماتیک',
        'toggleEmoticonsLabel'  => 'شکلک ها',
        'toggleAutoShowLabel'   => 'نمایش اتوماتیک',
        'contactHeader'         => 'ارتباط با ما',
        'contactInfo'           => 'تمامی اپراتور ها آفلاین هستند ، شما میتوانید سوال خود را در کادر زیر وارد کنید. در کمترین زمان پاسخ به ایمیل شما ارسال می شود',
        'contactNameLabel'      => 'نام شما',
        'contactMailLabel'      => 'ایمیل شما',
        'contactQuestionLabel'  => 'پرسش شما',
        'contactSendLabel'      => 'ارسال',
        'contactSuccessHeader'  => 'پیام شما ارسال شد',
        'contactSuccessMessage' => 'پرسش شما با موفقیت ارسال شد. از ارتباط شما متشکریم',
        'contactErrorHeader'    => 'خطا',
        'contactErrorMessage'   => 'یک خطای نامشخص در هنگام ارسال پرسش رخ داده. لطفا مجددا سعی کنید'
    )
);

// Generate connection strings

$config['dbConnectionRaw_mysql'] = 'mysql:host=' . $config['dbHost'] . ';port=' . $config['dbPort'];
$config['dbConnection_mysql']    = 'mysql:dbname=' . $config['dbName'] . ';host=' . $config['dbHost'] . ';port=' . $config['dbPort'];

// Used connection strings

$config['dbConnectionRaw'] = $config['dbConnectionRaw_' . $config['dbType']];
$config['dbConnection']    = $config['dbConnection_'    . $config['dbType']];

return $config;

?>
