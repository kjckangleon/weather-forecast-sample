<?php

namespace App\Service;

use App\Exceptions\ForecastNotCreatedException;
use App\Forecast;
use App\Http\Resources\ForecastResource;
use Exception;
use Illuminate\Support\Facades\DB;

class ForecastService
{
    protected $forecast;
    public function __construct(Forecast $forecast) 
    {
      $this->forecast = $forecast;
    }
    
    public function getAll()
    {
        return $this->forecast->all();
    }

    public function create($params) {
		DB::beginTransaction();
			try {
				$forecast = new ForecastResource($this->forecast->create($params));

				// if (!($forecast instanceof Forecast)) {
				//   throw new ForecastNotCreatedException;
				// }

				$forecast->save();

				DB::commit();
			  return $forecast;
			} catch (Exception $e) {
				DB::rollback();
				throw $e;
		}
	}
}
