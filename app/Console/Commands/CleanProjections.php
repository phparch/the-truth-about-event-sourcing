<?php

namespace App\Console\Commands;

use App\Models\Contact;
use Illuminate\Console\Command;
use Thunk\Verbs\Models\VerbSnapshot;
use Thunk\Verbs\Models\VerbStateEvent;
use function Laravel\Prompts\confirm;

class CleanProjections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-projections {--confirm}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->input->setOption('confirm', confirm(
            label: 'This will destroy your data. Are you sure you want to continue? ',
            default: false,
        ));

        dump($this->option('confirm'));
        if ($this->option('confirm')) {
            $this->info('Truncating Contacts...');
            Contact::truncate();
/*            $this->info('Truncating Verbs Snapshot...');
            VerbSnapshot::truncate();
            $this->info('Truncating Verbs State Events...');
            VerbStateEvent::truncate();*/
        } else {
            $this->info('Aborting...');
        }
    }
}
