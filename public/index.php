<?php
require '../vendor/autoload.php';

use \Demo\HelloWorld as World;
use Demo\Hello\Lara;
use Demo\Hello;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Carbon\Carbon;

//--Demo------------------------------------------------------
$world = new World();
$lara= new Lara();
$vincent= new Hello\Someone('Vincent');

// 以下Someone類別的使用可以不用use Demo\Hello;
$mary= new \Demo\Hello\Someone('Mary');
$john= new Demo\Hello\Someone('John');

echo PHP_EOL;

//--monolog---------------------------------------------------
// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('../log/your.log', Logger::WARNING));

// add records to the log
$log->warning('Foo');
$log->error('Bar');

//--nesbot----------------------------------------------------
printf("Right now is %s".PHP_EOL, Carbon::now()->toDateTimeString());
printf("Right now in Vancouver is %s".PHP_EOL, Carbon::now('America/Vancouver'));  //implicit __toString()
printf("Right now in Taipei is %s".PHP_EOL, Carbon::now('Asia/Taipei'));  //implicit __toString()
$tomorrow = Carbon::now()->addDay();
$lastWeek = Carbon::now()->subWeek();
$nextSummerOlympics = Carbon::createFromDate(2016)->addYears(4);

$officialDate = Carbon::now()->toRfc2822String();

$howOldAmI = Carbon::createFromDate(1975, 5, 21)->age;

$noonTodayLondonTime = Carbon::createFromTime(12, 0, 0, 'Europe/London');

$internetWillBlowUpOn = Carbon::create(2038, 01, 19, 3, 14, 7, 'GMT');

echo PHP_EOL;
// Don't really want this to happen so mock now
Carbon::setTestNow(Carbon::createFromDate(2000, 1, 1));

// comparisons are always done in UTC
if (Carbon::now()->gte($internetWillBlowUpOn)) {
    die();
}

// Phew! Return to normal behaviour
Carbon::setTestNow();

if (Carbon::now()->isWeekend()) {
    echo 'Party!'.PHP_EOL;
}

echo PHP_EOL;

// Over 200 languages (and over 500 regional variants) supported:
echo Carbon::now()->subMinutes(2)->diffForHumans().PHP_EOL; // '2 minutes ago'
echo Carbon::now()->subMinutes(2)->locale('zh_CN')->diffForHumans().PHP_EOL; // '2分钟前'
echo Carbon::now()->subMinutes(2)->locale('zh_TW')->diffForHumans().PHP_EOL; // '2分鐘前'
echo Carbon::parse('2019-07-23 14:51')->isoFormat('LLLL').PHP_EOL; // 'Tuesday, July 23, 2019 2:51 PM'
echo Carbon::parse('2019-07-23 14:51')->locale('fr_FR')->isoFormat('LLLL').PHP_EOL; // 'mardi 23 juillet 2019 14:51'

// ... but also does 'from now', 'after' and 'before'
// rolling up to seconds, minutes, hours, days, months, years

$daysSinceEpoch = Carbon::createFromTimestamp(0)->diffInDays();