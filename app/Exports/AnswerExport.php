<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AnswerExport implements WithMultipleSheets
{
	use Exportable;
	protected $questionnaire_id;
	protected $questionnaireRegistration_id;

	public function __construct($questionnaire_id,$questionnaireRegistration_id = null)
	{
		$this->questionnaire_id = $questionnaire_id;
		$this->questionnaireRegistration_id = $questionnaireRegistration_id;
	}


	public function sheets(): array
	{
		$sheets = [];

		$sheets[] = new AnswerExportFullTable($this->questionnaire_id,$this->questionnaireRegistration_id);
		$sheets[] = new AnswerExportChartData($this->questionnaire_id,$this->questionnaireRegistration_id);


		return $sheets;
	}
}
