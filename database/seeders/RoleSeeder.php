<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    // nama role persis sesuai divisi
    public static array $roles = [
        'webmaster',
        'perencanaan_konten',
        'fotographer',
        'videographer',
        'copywriting',
        'illustrator',
        'reporter',
        'desain_grafis',
    ];

    public static array $permissions = [
        // manajemen sistem (khusus webmaster)
        'manage-users',
        'manage-roles',
        'manage-divisions',

        // konten berita
        'berita.create',
        'berita.update',
        'berita.delete',
        'berita.publish',
        'berita.view-all',

        // konten artikel
        'artikel.create',
        'artikel.update',
        'artikel.delete',
        'artikel.publish',
        'artikel.view-all',

        // kategori
        'categories.manage',

        // task management
        'tasks.assign',       // PK bikin & assign task
        'tasks.view-all',     // lihat semua task (WM, PK)
        'tasks.view-own',     // divisi pelaksana cuma lihat task miliknya
        'tasks.update-status',// divisi pelaksana update status task

        // media
        'media.upload',
    ];

    public function run(): void
    {
        foreach (self::$permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        foreach (self::$roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // --- Dashboard A: Webmaster -> full access ---
        Role::findByName('webmaster')->syncPermissions(Permission::all());

        // --- Dashboard B: Perencanaan Konten -> CRUD konten + assign task ---
        Role::findByName('perencanaan_konten')->syncPermissions([
            'berita.create', 'berita.update', 'berita.delete', 'berita.publish', 'berita.view-all',
            'artikel.create', 'artikel.update', 'artikel.delete', 'artikel.publish', 'artikel.view-all',
            'categories.manage',
            'tasks.assign', 'tasks.view-all',
            'media.upload',
        ]);

        // --- Dashboard C: divisi pelaksana -> lihat & update status task milik sendiri ---
        $pelaksana = [
            'fotographer', 'videographer', 'copywriting',
            'illustrator', 'reporter', 'desain_grafis',
        ];

        foreach ($pelaksana as $role) {
            Role::findByName($role)->syncPermissions([
                'tasks.view-own',
                'tasks.update-status',
                'media.upload',
            ]);
        }
    }
}
