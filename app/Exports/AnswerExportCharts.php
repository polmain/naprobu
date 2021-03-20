<?php

namespace App\Exports;

use App\Model\Questionnaire;
use App\Model\Questionnaire\Question;
use App\Model\Project\ProjectRequest;



use Maatwebsite\Excel\Concerns\Exportable;


use Maatwebsite\Excel\Concerns\WithCharts;

use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;


class AnswerExportCharts implements WithCharts
{
	use Exportable;
	protected $questionnaire_id;

	public function __construct($questionnaire_id)
	{
		$this->questionnaire_id = $questionnaire_id;
	}

	public function charts()
	{
		$charts = [];

		$questionnaire = Questionnaire::with(['project'])
			->find($this->questionnaire_id);
		$questions = Question::with(['options','answers.request.user'])
			->where('questionnaire_id',$this->questionnaire_id)
			->get();
		$status = 1;
		if($questionnaire->type_id >= 3){
			$status = 9;
		}
		$requests = ProjectRequest::with(['user','answers.question.parent_question'])
			->where([
				['status_id','>=',$status],
				['project_id',$questionnaire->project_id],
			])
			->get();
		$rowStart = 1;
		$rowEnd = 1;
		foreach($questions as $question){
			if($question->type_id == 3 || $question->type_id == 4 || $question->type_id == 5){
				$rowStart = $rowEnd+1;

				$rowEnd++;
				$label      = [new DataSeriesValues('String', null, null, 1, $question->name)];
				$categoriesArr = [];
				$valuesArr = [];
				foreach($question->options as $child){
					if($child->rus_lang_id == 0){
						$categoriesArr[] = $child->name;
						$valuesArr[] = $child->answers->count();
						$rowEnd++;
					}
				}

				$categories = [new DataSeriesValues('String', null, null, count($categoriesArr),$categoriesArr)];
				$values     = [new DataSeriesValues('Number', null, null, count($valuesArr),$valuesArr)];

				$series = new DataSeries(DataSeries::TYPE_PIECHART, DataSeries::GROUPING_STANDARD,
					range(0, \count($values) - 1), $label, $categories, $values);
				$plot   = new PlotArea(null, [$series]);

				$legend = new Legend();
				$chart  = new Chart('chart name'.$question->id, new Title('chart title'.$question->id), $legend, $plot);

				$chart->setTopLeftPosition('E'.$rowStart);
				$chart->setBottomRightPosition('H'.$rowEnd);

				$charts[] = $chart;
				$rowEnd++;
			}
		}


		return $charts;
	}

}
