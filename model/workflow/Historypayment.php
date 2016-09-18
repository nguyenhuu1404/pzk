<?php
class PzkWorkflowHistorypaymentModel {
	public function cancel($entity, $value) {
		
	}
	public function active($entity, $value) {
		$entity->setPaymentstatus('1');
		$entity->save();
	}
}