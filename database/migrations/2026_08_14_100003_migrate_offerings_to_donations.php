<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    public function up(): void
    {
        $typeMap = [
            'oferta' => 'offering',
            'dizimo' => 'tithe',
        ];

        $userToMember = DB::table('members')->whereNotNull('user_id')->pluck('id', 'user_id');

        $offerings = DB::table('offerings')->get();

        foreach ($offerings as $offering) {
            DB::table('donations')->insert([
                'uuid' => (string) Str::uuid(),
                'church_id' => 1,
                'member_id' => $userToMember->get($offering->user_id),
                'type' => $typeMap[$offering->type] ?? 'donation',
                'description' => $offering->notes,
                'amount' => $offering->amount,
                'status' => 'paid',
                'payment_id' => null,
                'is_anonymous' => false,
                'source' => 'manual',
                'payment_method' => $offering->payment_method,
                'created_at' => $offering->offering_date,
                'updated_at' => now(),
            ]);
        }

        Permission::where('name', 'manage offerings')->delete();

        Schema::dropIfExists('offerings');
    }

    public function down(): void
    {
        Schema::create('offerings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('type')->default('oferta');
            $table->decimal('amount', 10, 2);
            $table->date('offering_date');
            $table->string('payment_method')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'offering_date']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        $fallbackUserId = DB::table('users')->orderBy('id')->value('id');
        $memberToUser = DB::table('members')->whereNotNull('user_id')->pluck('user_id', 'id');

        $manual = DB::table('donations')->where('source', 'manual')->get();

        foreach ($manual as $donation) {
            DB::table('offerings')->insert([
                'user_id' => $memberToUser->get($donation->member_id) ?? $fallbackUserId,
                'type' => $donation->type === 'tithe' ? 'dizimo' : ($donation->type === 'offering' ? 'oferta' : 'oferta'),
                'amount' => $donation->amount,
                'offering_date' => $donation->created_at,
                'payment_method' => $donation->payment_method,
                'notes' => $donation->description,
                'created_by' => $fallbackUserId,
                'created_at' => $donation->created_at,
                'updated_at' => $donation->updated_at,
            ]);
        }
    }
};