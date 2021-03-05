<?php

namespace App\Http\Livewire\Settings;

use App\Entities\Hook;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Nwidart\Modules\Facades\Module;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use ZipArchive;

class Modules extends Component
{
    use WithFileUploads;

    public $module;

    public function install()
    {
        if (isDemo()) {
            toastr()->error('Not allowed in demo mode');
            return redirect()->to('/settings/modules');
        }
        $this->validate([
            'module' => 'required',
        ]);
        if ($message = $this->extract($this->module)) {
            if (!is_object($message)) {
                session()->flash('danger', 'Ensure your module contains module.json file');
                return redirect()->to('/settings/modules');
            }
        }
        $this->registerModules();
        $this->runMigrations();
        Artisan::call('permission:cache-reset');

        Cache::forget('workice-main-menu-' . Auth::id());

        session()->flash('success', 'Module installed successfully');

        return redirect()->to('/settings/modules');
    }
    public function updatedModule()
    {
        $this->validate([
            'module' => 'mimetypes:application/octet-stream,application/zip,application/x-zip-compressed,application/x-compressed,multipart/x-zip',
        ]);
    }

    public function moduleStatus($module)
    {
        if (isDemo()) {
            toastr()->error('Not allowed in demo mode');
            return redirect()->to('/settings/modules');
        }
        $status = 'enabled';
        $module = Module::findOrFail($module);
        $menu = Hook::where(['module' => 'menu_' . strtolower($module)])->first();
        if ($module->isEnabled()) {
            $status = 'disabled';
            Artisan::call('module:disable', ['module' => $module]);
            if (isset($menu->id)) {
                $menu->update(['visible' => 0, 'enabled' => 0]);
            }
        } else {
            Artisan::call('module:enable', ['module' => $module]);
            if (isset($menu->id)) {
                $menu->update(['visible' => 1, 'enabled' => 1]);
            }
        }
        Cache::forget('workice-main-menu-' . Auth::id());
        session()->flash('success', 'Module ' . $module . ' successfully ' . $status);
        return redirect()->to('/settings/modules');
    }

    public function deleteModule($module)
    {
        if (isDemo()) {
            toastr()->error('Not allowed in demo mode');
            return redirect()->to('/settings/modules');
        }
        $module = Module::findOrFail($module);
        $menu = Hook::where(['module' => 'menu_' . strtolower($module)])->first();
        if (isset($menu->id)) {
            $this->revokePermission($menu);
            $this->deletePermission($menu);
            $menu->delete();
        }
        $module->delete();
        Cache::forget('workice-main-menu-' . Auth::id());
        Artisan::call('permission:cache-reset');
        session()->flash('success', 'Module ' . $module . ' successfully deleted.');
        return redirect()->to('/settings/modules');
    }

    public function render()
    {
        return view('livewire.settings.modules');
    }

    /**
     * Extract the zip file into the given directory.
     * @param  string $zipFile
     * @param  string $directory
     * @return $this
     */
    protected function extract($zipFile)
    {
        $zipFile = $zipFile->store('modules-tmp');
        //$finder = app(Filesystem::class);
        $modulesPath = config('modules.paths.modules');

        $archive = new ZipArchive();
        $archive->open(storage_path('app/' . $zipFile));
        $archive->extractTo($modulesPath);

        $original = $modulesPath . '/' . $archive->getNameIndex(0);
        $metadata = [];
        try {
            $metadata = json_decode(file_get_contents($original . '/module.json'));
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        $this->saveMenu($metadata);
        $this->savePermission($metadata);
        $this->assignAdminPermission($metadata);
        //$finder->move($original, $directory);
        $archive->close();

        $this->cleanTemporaryDir();

        return $metadata;
    }

    protected function cleanTemporaryDir()
    {
        $disk = new FileSystem;
        return collect(
            $disk->allFiles(storage_path('app/modules-tmp'))
        )->each(
            function ($file) use ($disk) {
                $disk->delete($file);
            }
        )->count();
    }

    protected function registerModules()
    {
        Module::register();
        Module::boot();
        Artisan::call('cache:clear');
        return $this;
    }
    protected function saveMenu($metadata)
    {
        return Hook::firstOrCreate(
            ['module' => 'menu_' . strtolower($metadata->name)],
            [
                'hook' => 'main_menu',
                'icon' => 'fas fa-' . $metadata->icon,
                'name' => strtolower($metadata->name),
                'route' => strtolower($metadata->name),
                'order' => Hook::count() + 1,
                'parent' => '',
                'access' => 1,
            ]);
    }
    protected function savePermission($metadata)
    {
        return Permission::firstOrCreate([
            'name' => 'menu_' . strtolower($metadata->name),
            'description' => 'Allow user to access module ' . $metadata->name,
        ]);
    }
    protected function assignAdminPermission($metadata)
    {
        $role = Role::where('name', 'admin')->first();
        $role->givePermissionTo('menu_' . strtolower($metadata->name));
    }
    protected function revokePermission($menu)
    {
        $role = Role::where('name', 'admin')->first();
        $role->revokePermissionTo($menu->module);
    }
    protected function deletePermission($menu)
    {
        return Permission::where('name', $menu->module)->delete();
    }
    protected function runMigrations()
    {
        Artisan::call('migrate', ['--force' => true]);
        return $this;
    }
}
