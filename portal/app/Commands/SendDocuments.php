<?php namespace App\Commands;

use App\Commands\Command;

use App\Document;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class SendDocuments extends Command implements SelfHandling, ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;

	protected $document;

	/**
	 * Create a new command instance.
	 *
	 * @param Document $document
	 */
	public function __construct($data)
	{
		$this->document = $data;
	}

	public function handle()
	{
		
	}

}
