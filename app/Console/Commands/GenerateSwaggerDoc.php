<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSwaggerDoc extends Command
{
    protected $signature = 'swagger:generate';

    protected $description = 'Generate swagger.json documentation';

    public function handle()
    {
        $openapi = \OpenApi\scan(app_path());
        file_put_contents(public_path('swagger.json'), $openapi->toJson());
        $this->info('Swagger documentation generated successfully.');
    }
}
