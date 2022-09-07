<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tasks extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('task_model');
	}

	/**
	 * Get All Data from this method.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data['data'] = $this->task_model->get_tasks();
		$this->load->view('tasks', $data);
	}

	public function taskList()
	{
		$data['data'] = $this->task_model->get_tasks();
		$this->load->view('tasks', $data);
	}

	/**
	 * Submit task from this method.
	 *
	 * @return Response
	 */
	public function taskSubmit()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('task_name', 'Task Name', 'trim|required');
		$this->form_validation->set_rules('task_date', 'Task Date', 'trim|required');
		$this->form_validation->set_rules('task_desc', 'Task Description', 'trim|required');

		if ($this->form_validation->run() == false) {
			$response = array(
				'status' => 'error',
				'message' => validation_errors()
			);
		} else {
			$taskData = array(
				'task_name' => $this->input->post('task_name', true),
				'task_date' => date('Y-m-d', strtotime($this->input->post('task_date', true))),
				'task_desc' => $this->input->post('task_desc', true)
			);

			$id = $this->task_model->insert_tasks($taskData);


			$response = array(
				'status' => 'success',
				'message' => "Task added successfully.",
				'data' => $taskData,
				'id' => $id
			);
		}

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	/**
	 * Delete from this method.
	 *
	 * @return Response
	 */
	public function deleteTask()
	{
		$id = $this->input->post('id');
		$delete = $this->task_model->delete_tasks($id);
		if ($delete) {

			$response = array(
				'status' => 'success',
				'message' => "Deleted successfully"
			);
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($response));
		}
	}
}
