<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkflowSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $data = [
      [
        "id" => 1,
        "name" => "Leave Application",
        "description" => "Workflow for leave application",
        "initiation_role" => 1,
        "worker_roles" => 2,
        "status" => "inactive",
        "email_reminder" => true,
        "web_notification" => true,
      ],
      [
        "id" => 2,
        "name" => "Overtime Request",
        "description" => "Workflow for overtime request",
        "initiation_role" => 3,
        "worker_roles" => 4,
        "status" => "inactive",
        "email_reminder" => true,
        "web_notification" => false,
      ],
      [
        "id" => 3,
        "name" => "Sick Leave Application",
        "description" => "Workflow for sick leave application",
        "initiation_role" => 5,
        "worker_roles" => 6,
        "status" => "inactive",
        "email_reminder" => false,
        "web_notification" => true,
      ],
      [
        "id" => 4,
        "name" => "Resignation Request",
        "description" => "Workflow for resignation request",
        "initiation_role" => 7,
        "worker_roles" => 8,
        "status" => "inactive",
        "email_reminder" => true,
        "web_notification" => false,
      ],
      [
        "id" => 5,
        "name" => "Task Approval",
        "description" => "Workflow for task approval",
        "initiation_role" => 2,
        "worker_roles" => 9,
        "status" => "inactive",
        "email_reminder" => false,
        "web_notification" => true,
      ],
      [
        "id" => 6,
        "name" => "Expense Reimbursement",
        "description" => "Workflow for expense reimbursement",
        "initiation_role" => 10,
        "worker_roles" => 1,
        "status" => "inactive",
        "email_reminder" => true,
        "web_notification" => false,
      ],
      [
        "id" => 7,
        "name" => "Project Approval",
        "description" => "Workflow for project approval",
        "initiation_role" => 3,
        "worker_roles" => 5,
        "status" => "inactive",
        "email_reminder" => false,
        "web_notification" => true,
      ],
      [
        "id" => 8,
        "name" => "Document Review",
        "description" => "Workflow for document review",
        "initiation_role" => 6,
        "worker_roles" => 7,
        "status" => "inactive",
        "email_reminder" => true,
        "web_notification" => false,
      ],
      [
        "id" => 9,
        "name" => "Training Request",
        "description" => "Workflow for training request",
        "initiation_role" => 9,
        "worker_roles" => 4,
        "status" => "inactive",
        "email_reminder" => false,
        "web_notification" => true,
      ],
      [
        "id" => 10,
        "name" => "Purchase Order",
        "description" => "Workflow for purchase order",
        "initiation_role" => 8,
        "worker_roles" => 2,
        "status" => "inactive",
        "email_reminder" => true,
        "web_notification" => false,
      ],
    ];

    DB::table('workflows')->insert($data);
  }
}
