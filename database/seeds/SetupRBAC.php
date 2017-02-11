<?php

use Illuminate\Database\Seeder;

class SetupRBAC extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #Permission
        $createPost = app(\Caffeinated\Shinobi\Models\Permission::class);
        $createPost->name = 'create-post';
        $createPost->slug = 'Create Posts';
        $createPost->description = 'create new blog posts';
        $createPost->save();

        $editUser = app(\Caffeinated\Shinobi\Models\Permission::class);
        $editUser->name = 'edit-user';
        $editUser->slug = 'Edit Users';
        $editUser->description = 'edit existing users';
        $editUser->save();

        #Role
        $owner = app(\Caffeinated\Shinobi\Models\Role::class);
        $owner->name = 'owner';
        $owner->slug = 'Project Owner';
        $owner->description = 'User is the owner of a given project';
        $owner->save();

        $owner->syncPermissions([$createPost->id, $editUser->id]);
    }
}
