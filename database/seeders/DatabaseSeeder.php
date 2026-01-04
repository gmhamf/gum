<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Gym;
use App\Models\Trainer;
use App\Models\Member;
use App\Models\Subscription;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // إنشاء قاعة تجريبية
        $gym = Gym::create([
            'name' => 'جيم اوريوس',
            'email' => 'gym@example.com',
            'password' => Hash::make('123456'),
            'phone' => '07701234567',
            'address' => 'النجف - العسكري',
            'subscription_type' => 'monthly',
            'status' => true
        ]);

        // إنشاء مدرب تجريبي
        $trainer = Trainer::create([
            'gym_id' => $gym->id,
            'name' => 'علي المدرب',
            'email' => 'trainer@example.com',
            'password' => Hash::make('123456'),
            'phone' => '07701234568',
            'specialization' => 'كمال الأجسام واللياقة البدنية',
            'experience' => 5,
            'status' => true
        ]);

        // إنشاء عضو تجريبي
        $member = Member::create([
            'gym_id' => $gym->id,
            'trainer_id' => $trainer->id,
            'name' => 'محمد صادق',
            'member_code' => 'MEM001',
            'password' => Hash::make('123456'),
            'email' => 'member@example.com',
            'phone' => '07701234569',
            'weight' => 63.5,
            'height' => 175,
            'age' => 19,
            'gender' => 'male',
            'join_date' => now(),
            'status' => true
        ]);

        // إنشاء اشتراك للعضو
        Subscription::create([
            'member_id' => $member->id,
            'type' => 'monthly',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'amount' => 30000,
            'status' => 'active'
        ]);

        $this->command->info('✅ تم إنشاء بيانات الاختبار بنجاح!');
        $this->command->info('📋 بيانات الدخول:');
        $this->command->info('   - صاحب القاعة: gym@example.com / 123456');
        $this->command->info('   - المدرب: trainer@example.com / 123456');
        $this->command->info('   - اللاعب: القاعة: جيم النخبة، رقم العضوية: MEM001، كلمة المرور: 123456');
    }
}
