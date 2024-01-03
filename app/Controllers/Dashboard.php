<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\Files\UploadedFile;

/**
 * Dashboard
 */
helper('breadcrumb');
class Dashboard extends BaseController
{

    function index()
    {
        $data['_view'] = 'dashboard';
        $data['title'] = 'Dashboard';
        $data['breadcrumb'] = dashboard();
        $db = db_connect();
        $session = $data['session'] = session();
        $data['documents'] = [];
        $data['recent'] = [];
        if ($session->role_id == 1 || $session->role_id == 2 || $session->role_id == 3) {
            $data['pending'] = $db->table('documents')->where('approvalStatus', 0)->get()->getResultArray();
            $data['approved'] = $db->table('documents')->where('approvalStatus', 1)->get()->getResultArray();
            $data['rejected'] = $db->table('documents')->where('approvalStatus', 2)->get()->getResultArray();
            $data['quotation'] = $db->table('quotation q')->join('admin a', 'a.admin_id=q.company_id')->join('documents d', 'd.document_id=q.document_id')->get()->getResultArray();
        }
        if ($session->role_id == 5) {
            $data['pending'] = $db->table('documents')->where('approvalStatus', 0)->get()->getResultArray();
            $data['approved'] = $db->table('documents')->where('approvalStatus', 1)->get()->getResultArray();
            $data['rejected'] = $db->table('documents')->where('approvalStatus', 2)->get()->getResultArray();
            $data['quotation'] = $db->table('quotation q')->where("q.company_id", $session->admin_id)->join('admin a', 'a.admin_id=q.company_id')->join('documents d', 'd.document_id=q.document_id')->get()->getResultArray();
        }
        if ($session->role_id == 4) {
            $data['pending'] = $db->table('documents')->where('approvalStatus', 0)->get()->getResultArray();
            $data['approved'] = $db->table('documents')->where('approvalStatus', 1)->get()->getResultArray();
            $data['rejected'] = $db->table('documents')->where('approvalStatus', 2)->get()->getResultArray();
            $data['quotation'] = $db->table('quotation q')->where("q.company_id", $session->admin_id)->join('admin a', 'a.admin_id=q.company_id')->join('documents d', 'd.document_id=q.document_id')->get()->getResultArray();
            $data['companies'] = $db->table('admin')->where("role_id", 5)->get()->getResultArray();
            $data['budget'] = $db->table('budget')->where("activeStatus", 1)->get()->getRowArray();            
            $data['total'] = $db->table('documents')->select('SUM(bill) as total')->get()->getRowArray() ;
        }
        return view('template', $data);
    }
    function add()
    {
        $session = session();
        $db = db_connect();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if ($_FILES['intent']['error'] != 0 && $_FILES["tablet"]['error'] != 0) {

                $session->setFlashdata('error', 'you have upload atleast one document ');
                return redirect()->to(site_url('/dashboard'));
            } else {
                $pfilename = "";
                if ($_FILES['intent']['error'] == 0) {
                    $file = $this->request->getFile('intent');

                    $name = $file->getName();
                    $ext = (explode(".", $name)); # extra () to prevent notice
                    $pfilename = time() . "." . $ext[count($ext) - 1];
                    $file->move("public/upload/intent/", $pfilename);
                }
                $param = array(
                    'intent' => $pfilename,
                    'comments' => $this->request->getPost('comments'),
                    'pendingFrom' => 2
                );
                $db->table("documents")->insert($param);
                $session->setFlashdata("success", "Success");
                 return redirect()->to(site_url('/dashboard'));
            }
        }
    }
    function reupload()
    {
        $session = session();
        $db = db_connect();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if ($_FILES['intent']['error'] != 0 && $_FILES["tablet"]['error'] != 0) {

                $session->setFlashdata('error', 'you have upload atleast one document ');
                return redirect()->to(site_url('/dashboard'));
            } else {
                $pfilename = "";
                if ($_FILES['intent']['error'] == 0) {
                    $file = $this->request->getFile('intent');

                    $name = $file->getName();
                    //var_dump($name);
                    $ext = (explode(".", $name)); # extra () to prevent notice
                    $pfilename = time() . "." . $ext[count($ext) - 1];
                    $file->move("public/upload/intent/", $pfilename);
                }
                $param = array(
                    'intent' => $pfilename,
                );
                $db->table("documents")->where('document_id', $this->request->getPost('documentId'))->update($param);
                $session->setFlashdata("success", "Success");

                return redirect()->to(site_url('/dashboard'));
            }
        }
    }

    function hodApprove($id)
    {
        $db = db_connect();
        $docs = $db->table('documents')->where('document_id', $id)->get()->getRowArray();
        if ($docs['principalApproval'] == true) {
            $param = array(
                'pendingFrom' => 0,
                'hodApproval' => true,
                'approvalStatus' => 1
            );
            $db->table("documents")->where('document_id', $id)->update($param);
        } else {
            $param = array(
                'pendingFrom' => 3,
            );
            $db->table("documents")->where('document_id', $id)->update($param);
        }
        return redirect()->to(site_url('/dashboard'));
    }
    function hodReject($id)
    {
        $db = db_connect();
        $docs = $db->table('documents')->where('document_id', $id)->get()->getRowArray();
        if ($docs['principalApproval'] == true) {
            $param = array(
                'pendingFrom' => 4,
                'principalApproval' => false
            );
            $db->table("documents")->where('document_id', $id)->update($param);
        } else {
            $param = array(
                'approvalStatus' => 2,
                'rejectReason' => $this->request->getPost('rejectReason')
            );
            $db->table("documents")->where('document_id', $id)->update($param);
        }

        return redirect()->to(site_url('/dashboard'));
    }
    function quotationUpload()
    {
        $session = session();
        $db = db_connect();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if ($_FILES['quotation']['error'] != 0) {

                $session->setFlashdata('error', 'you have upload atleast one document ');
                return redirect()->to(site_url('/dashboard'));
            } else {
                $pfilename = "";
                if ($_FILES['quotation']['error'] == 0) {
                    $file = $this->request->getFile('quotation');

                    $name = $file->getName();
                    //var_dump($name);
                    $ext = (explode(".", $name)); # extra () to prevent notice
                    $pfilename = time() . "." . $ext[count($ext) - 1];
                    $file->move("public/upload/quotation/", $pfilename);
                }
                $param = array(
                    'quotation' => $pfilename,
                );
                $db->table("documents")->where('document_id', $this->request->getPost('documentId'))->update($param);
                $session->setFlashdata("success", "Success");
                $company = $db->table('admin')->where('role_id', 5)->get()->getResultArray();
                foreach ($company as $c) {
                    $data = array(
                        'document_id' => $this->request->getPost('documentId'),
                        'company_id' => $c['admin_id'],
                        'invoice' => ""
                    );
                    $db->table('quotation')->insert($data);
                }
                return redirect()->to(site_url('/dashboard'));
            }
        }
    }

    function uploadInvoice()
    {
        $session = session();
        $db = db_connect();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if ($_FILES['invoice']['error'] != 0 && $_FILES["tablet"]['error'] != 0) {

                $session->setFlashdata('error', 'you have upload atleast one document ');
                return redirect()->to(site_url('/dashboard'));
            } else {
                $pfilename = "";
                if ($_FILES['invoice']['error'] == 0) {
                    $file = $this->request->getFile('invoice');

                    $name = $file->getName();
                    $ext = (explode(".", $name)); # extra () to prevent notice
                    $pfilename = time() . "." . $ext[count($ext) - 1];
                    $file->move("public/upload/invoice/", $pfilename);
                }
                $param = array(
                    'invoice' => $pfilename,
                );
                $db->table("quotation")->where('quotation_id', $this->request->getPost('quotationId'))->update($param);
                $session->setFlashdata("success", "Success");

                return redirect()->to(site_url('/dashboard'));
            }
        }
    }
    function comparativeUpload()
    {
        $session = session();
        $db = db_connect();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if ($_FILES['comparative']['error'] != 0 && $_FILES["tablet"]['error'] != 0) {

                $session->setFlashdata('error', 'you have upload atleast one document ');
                return redirect()->to(site_url('/dashboard'));
            } else {
                $pfilename = "";
                if ($_FILES['comparative']['error'] == 0) {
                    $file = $this->request->getFile('comparative');

                    $name = $file->getName();
                    $ext = (explode(".", $name)); # extra () to prevent notice
                    $pfilename = time() . "." . $ext[count($ext) - 1];
                   // var_dump($pfilename);
                    $file->move("public/upload/comparative/", $pfilename);
                }
                $param = array(
                    'comparative' => $pfilename,
                    'pendingFrom' => 4
                );
                $db->table("documents")->where('document_id', $this->request->getPost('documentId'))->update($param);
                $session->setFlashdata("success", "Success");

                return redirect()->to(site_url('/dashboard'));
            }
        }
    }

    function selectCompany()
    {
        $session = session();
        $db = db_connect();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $file = $this->request->getFile('billimage');
            $name = $file->getName();
                    $ext = (explode(".", $name)); # extra () to prevent notice
                    $pfilename = time() . "." . $ext[count($ext) - 1];
                    $file->move("public/upload/billimage/", $pfilename);
            $param = array(
                'company_id' => $this->request->getPost('company'),
                'bill' => $this->request->getPost('bill'),
                'billImage' => $pfilename,
                'pendingFrom' => '2',
                'principalApproval' => true
            );
            $db->table("documents")->where('document_id', $this->request->getPost('documentId'))->update($param);
            $session->setFlashdata("success", "Success");

            return redirect()->to(site_url('/dashboard'));
        }
    }

    function budget()
    {
        $session = session();
        $db = db_connect();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $db->table("budget")->where('activeStatus', 1)->update(array('activeStatus' => 0));
            $param = array(
                'budget' => $this->request->getPost('budget'),
            );
            $db->table("budget")->insert($param);
            return redirect()->to(site_url('/dashboard'));
        }
    }
}



/* End of file Admin.php */
/* Location: ./application/modules/admin/controllers/Admin.php */