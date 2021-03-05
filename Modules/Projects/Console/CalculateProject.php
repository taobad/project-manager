<?php

namespace Modules\Projects\Console;

use Illuminate\Console\Command;
use Modules\Projects\Entities\Project;

class CalculateProject extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'projects:balance {project?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates project summary and costs';

    /**
     * Project Model
     *
     * @var \Modules\Projects\Entities\Project
     */
    protected $project;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->project = new Project;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->argument('project');

        if ($id > 0) {
            $project = $this->project->findOrFail($id);
            $project->afterModelSaved();
        } else {
            $this->project->whereNull('archived_at')->chunk(
                200,
                function ($projects) {
                    foreach ($projects as $project) {
                        $project->afterModelSaved();
                    }
                }
            );
        }
        $this->info('Project balances calculated successfully');
    }
}
