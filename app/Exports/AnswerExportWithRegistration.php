<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AnswerExport implements WithMultipleSheets
{
	use Exportable;
	protected $questionnaire_id;

	public function __construct($questionnaire_id)
	{
		$this->questionnaire_id = $questionnaire_id;
	}


	public function sheets(): array
	{
		$sheets = [];

		$sheets[] = new AnswerExportFullTable($this->questionnaire_id);
		$sheets[] = new AnswerExportChartData($this->questionnaire_id);


		return $sheets;
	}
}
