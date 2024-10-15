<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Modify the existing columns or add new columns as per your requirements
            // For example, you might want to add new columns:
            $table->string('phone')->after('email')->nullable();
            $table->string('countryCode', 10)->after('phone')->nullable(); // Add country code column
            $table->boolean('userStatus')->default(0)->after('remember_token')->comment('0- Enable | 1-Disable');
            $table->integer('profileId')->after('userStatus');
            $table->string('package', 50)->after('profileId')->comment('relates to packages table');
            $table->integer('areaId')->after('package');
            $table->integer('planId')->after('areaId');
            $table->integer('balanceId')->after('planId');
            $table->integer('usedAddonId')->after('balanceId');
            $table->integer('adsAddonId')->after('usedAddonId');
            $table->integer('recharge')->after('adsAddonId')->default(0);
            $table->tinyInteger('packageStatus')->after('recharge')->default(0);
            $table->integer('packageStart')->after('packageStatus')->default(0);
            $table->integer('packageEnd')->after('packageStart')->default(0);
            $table->boolean('orderProcessed')->after('packageEnd')->default(0);
            $table->string('orderAmount', 50)->after('orderProcessed')->default('0');
            $table->string('callFreeSeconds', 20)->after('orderAmount')->default('0');
            $table->integer('callFreeSecondsUsed')->after('callFreeSeconds')->default(0);
            $table->string('phoneSetupBalc', 32)->after('callFreeSecondsUsed')->default('0');
            $table->string('phoneSetupBalcUsed', 32)->after('phoneSetupBalc')->default('0');
            $table->string('accBalance', 20)->after('phoneSetupBalcUsed')->default('0');
            $table->string('accBalanceUsed', 20)->after('accBalance')->default('0');
            $table->integer('accBalanceTime')->after('accBalanceUsed')->default(0);
            $table->integer('accBalanceTimeUsed')->after('accBalanceTime')->default(0);
            $table->string('callForwardNo', 20)->after('accBalanceTimeUsed')->default('');
            $table->string('callForwardOptions', 100)->after('callForwardNo')->default('');
            $table->text('callautoResponseMessage')->after('callForwardOptions')->default('');
            $table->integer('voiceMessageUsed')->after('callautoResponseMessage')->default(0);
            $table->text('current_phono_sessionId')->after('voiceMessageUsed')->default('');
            $table->integer('tropoUserAreaCode')->after('current_phono_sessionId')->default(0);
            $table->string('tropoUserNoType', 32)->after('tropoUserAreaCode')->default('');
            $table->text('tropoUserPhoneNo')->after('tropoUserNoType')->default('');
            $table->string('tropoPhNoPayType', 32)->after('tropoUserPhoneNo')->default('');
            $table->integer('paymentId')->after('tropoPhNoPayType')->comment('payments.paymentId')->default(0);
            $table->integer('phNoDueDate')->after('paymentId')->default(0);
            $table->integer('phNoExpired')->after('phNoDueDate')->default(0);
            $table->string('phNoStatus', 64)->after('phNoExpired')->default('');
            $table->tinyInteger('pageLoadStatus')->after('phNoStatus')->default(0);
            $table->boolean('onlineStatus')->after('pageLoadStatus')->default(0);
            $table->boolean('changePackageStatus')->after('onlineStatus')->default(0);
            $table->boolean('callForwardStatus')->default(0)->after('changePackageStatus')->comment('0-no || 1- yes');
            $table->boolean('autoResponseStatus')->default(0)->after('callForwardStatus')->comment('0-no || 1- yes');
            $table->boolean('voiceMessageStatus')->default(0)->after('autoResponseStatus')->comment('0-no || 1- yes');
            $table->tinyInteger('userSetting')->default(3)->after('voiceMessageStatus')->comment('1-autoResponse || 2 - no');
            $table->string('userRingtone', 1000)->default('aapcr_ringtone_default.mp3')->after('userSetting');
            $table->text('userVoiceMail')->after('userRingtone')->default('');
            $table->tinyInteger('userVoiceMailStatus')->after('userVoiceMail')->default(0);
            $table->integer('lastPingTime')->after('userVoiceMailStatus')->default(0);
            $table->tinyInteger('lastCallStatus')->after('lastPingTime')->default(0);
            $table->integer('userIp')->after('lastCallStatus')->default(0);
            $table->integer('userAgent')->after('userIp')->default(0);
            $table->boolean('directMedia')->default(1)->after('userAgent')->comment('1- true | 2 -false');
            $table->boolean('connectionService1')->default(2)->after('directMedia')->comment('1- true | 2 -false');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the columns that were added
            $table->dropColumn([
                'phone',
                'countryCode',
                'userStatus',
                'profileId',
                'package',
                'areaId',
                'planId',
                'balanceId',
                'usedAddonId',
                'adsAddonId',
                'recharge',
                'packageStatus',
                'packageStart',
                'packageEnd',
                'orderProcessed',
                'orderAmount',
                'callFreeSeconds',
                'callFreeSecondsUsed',
                'phoneSetupBalc',
                'phoneSetupBalcUsed',
                'accBalance',
                'accBalanceUsed',
                'accBalanceTime',
                'accBalanceTimeUsed',
                'callForwardNo',
                'callForwardOptions',
                'callautoResponseMessage',
                'voiceMessageUsed',
                'current_phono_sessionId',
                'tropoUserAreaCode',
                'tropoUserNoType',
                'tropoUserPhoneNo',
                'tropoPhNoPayType',
                'paymentId',
                'phNoDueDate',
                'phNoExpired',
                'phNoStatus',
                'pageLoadStatus',
                'onlineStatus',
                'changePackageStatus',
                'callForwardStatus',
                'autoResponseStatus',
                'voiceMessageStatus',
                'userSetting',
                'userRingtone',
                'userVoiceMail',
                'userVoiceMailStatus',
                'lastPingTime',
                'lastCallStatus',
                'userIp',
                'userAgent',
                'directMedia',
                'connectionService1',
                
            ]);
        });
    }
};
