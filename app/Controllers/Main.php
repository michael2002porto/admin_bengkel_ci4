<?php

namespace App\Controllers;

use App\Models\Auth;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\BranchOffice;

class Main extends BaseController
{
    protected $request;

    public function __construct()
    {
        $this->request = \Config\Services::request();
        $this->session = session();
        $this->auth_model = new Auth;
        $this->prod_model = new Product;
        $this->tran_model = new Transaction;
        $this->tran_item_model = new TransactionItem;
        $this->bran_model = new BranchOffice;
        $this->data = ['session' => $this->session, 'request' => $this->request];
    }

    public function index()
    {
        $this->data['page_title'] = "Home";
        $this->data['jumlah_produk'] = $this->prod_model->countAllResults();
        $this->data['jumlah_transaksi'] = $this->tran_model->countAllResults();
        $this->data['jumlah_user'] = $this->auth_model->countAllResults();
        $this->data['jumlah_cabang'] = $this->bran_model->countAllResults();
        return view('pages/home', $this->data);
    }

    public function users()
    {
        $this->data['page_title'] = "Users";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        $this->data['total'] =  $this->auth_model->where("id != '{$this->session->login_id}'")->countAllResults();
        $this->data['users'] = $this->auth_model->where("id != '{$this->session->login_id}'")->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['users']) ? count($this->data['users']) : 0;
        $this->data['pager'] = $this->auth_model->pager;
        return view('pages/users/list', $this->data);
    }
    public function user_add()
    {
        if ($this->request->getMethod() == 'post') {
            extract($this->request->getPost());
            if ($password !== $cpassword) {
                $this->session->setFlashdata('error', "Password does not match.");
            } else {
                $udata = [];
                $udata['name'] = $name;
                $udata['email'] = $email;
                if (!empty($password))
                    $udata['password'] = password_hash($password, PASSWORD_DEFAULT);
                $checkMail = $this->auth_model->where('email', $email)->countAllResults();
                if ($checkMail > 0) {
                    $this->session->setFlashdata('error', "User Email Already Taken.");
                } else {
                    $save = $this->auth_model->save($udata);
                    if ($save) {
                        $this->session->setFlashdata('main_success', "User Details has been updated successfully.");
                        return redirect()->to('Main/users');
                    } else {
                        $this->session->setFlashdata('error', "User Details has failed to update.");
                    }
                }
            }
        }

        $this->data['page_title'] = "Add User";
        return view('pages/users/add', $this->data);
    }
    public function user_edit($id = '')
    {
        if (empty($id))
            return redirect()->to('Main/users');
        if ($this->request->getMethod() == 'post') {
            extract($this->request->getPost());
            if ($password !== $cpassword) {
                $this->session->setFlashdata('error', "Password does not match.");
            } else {
                $udata = [];
                $udata['name'] = $name;
                $udata['email'] = $email;
                if (!empty($password))
                    $udata['password'] = password_hash($password, PASSWORD_DEFAULT);
                $checkMail = $this->auth_model->where('email', $email)->where('id!=', $id)->countAllResults();
                if ($checkMail > 0) {
                    $this->session->setFlashdata('error', "User Email Already Taken.");
                } else {
                    $update = $this->auth_model->where('id', $id)->set($udata)->update();
                    if ($update) {
                        $this->session->setFlashdata('success', "User Details has been updated successfully.");
                        return redirect()->to('Main/user_edit/' . $id);
                    } else {
                        $this->session->setFlashdata('error', "User Details has failed to update.");
                    }
                }
            }
        }

        $this->data['page_title'] = "Edit User";
        $this->data['user'] = $this->auth_model->where("id ='{$id}'")->first();
        return view('pages/users/edit', $this->data);
    }

    public function user_delete($id = '')
    {
        if (empty($id)) {
            $this->session->setFlashdata('main_error', "user Deletion failed due to unknown ID.");
            return redirect()->to('Main/users');
        }
        $delete = $this->auth_model->where('id', $id)->delete();
        if ($delete) {
            $this->session->setFlashdata('main_success', "User has been deleted successfully.");
        } else {
            $this->session->setFlashdata('main_error', "user Deletion failed due to unknown ID.");
        }
        return redirect()->to('Main/users');
    }

    public function branch_offices()
    {
        $this->data['page_title'] = "Branch Offices";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        $this->data['total'] =  $this->bran_model->where("id != '{$this->session->login_id}'")->countAllResults();
        $this->data['branch_offices'] = $this->bran_model->where("id != '{$this->session->login_id}'")->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['branch_offices']) ? count($this->data['branch_offices']) : 0;
        $this->data['pager'] = $this->bran_model->pager;
        return view('pages/branch_offices/list', $this->data);
    }
    public function branch_office_add()
    {
        if ($this->request->getMethod() == 'post') {
            extract($this->request->getPost());
            $udata = [];
            $udata['office_name'] = $office_name;
            $udata['location'] = $location;
            $checkName = $this->bran_model->where('office_name', $office_name)->countAllResults();
            if ($checkName > 0) {
                $this->session->setFlashdata('error', "Branch Office Name Already Taken.");
            } else {
                $save = $this->bran_model->save($udata);
                if ($save) {
                    $this->session->setFlashdata('main_success', "User Details has been updated successfully.");
                    return redirect()->to('Main/branch_offices');
                } else {
                    $this->session->setFlashdata('error', "User Details has failed to update.");
                }
            }
        }

        $this->data['page_title'] = "Add Branch Office";
        return view('pages/branch_offices/add', $this->data);
    }
    public function branch_office_edit($id = '')
    {
        if (empty($id))
            return redirect()->to('Main/branch_offices');
        if ($this->request->getMethod() == 'post') {
            extract($this->request->getPost());
            $udata = [];
            $udata['office_name'] = $office_name;
            $udata['location'] = $location;
            $checkName = $this->bran_model->where('office_name', $office_name)->where('id!=', $id)->countAllResults();
            if ($checkName > 0) {
                $this->session->setFlashdata('error', "Branch Office Name Already Taken.");
            } else {
                $update = $this->bran_model->where('id', $id)->set($udata)->update();
                if ($update) {
                    $this->session->setFlashdata('success', "Branch Office Details has been updated successfully.");
                    return redirect()->to('Main/branch_office_edit/' . $id);
                } else {
                    $this->session->setFlashdata('error', "Branch Office Details has failed to update.");
                }
            }
        }

        $this->data['page_title'] = "Edit Branch Office";
        $this->data['branch_office'] = $this->bran_model->where("id ='{$id}'")->first();
        return view('pages/branch_offices/edit', $this->data);
    }

    public function branch_office_delete($id = '')
    {
        if (empty($id)) {
            $this->session->setFlashdata('main_error', "Branch Office Deletion failed due to unknown ID.");
            return redirect()->to('Main/branch_offices');
        }
        $delete = $this->bran_model->where('id', $id)->delete();
        if ($delete) {
            $this->session->setFlashdata('main_success', "Branch Office has been deleted successfully.");
        } else {
            $this->session->setFlashdata('main_error', "Branch Office Deletion failed due to unknown ID.");
        }
        return redirect()->to('Main/branch_offices');
    }

    public function products()
    {
        $this->data['page_title'] = "Products";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        $this->data['total'] =  $this->prod_model->countAllResults();
        $this->data['products'] = $this->prod_model->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['products']) ? count($this->data['products']) : 0;
        $this->data['pager'] = $this->prod_model->pager;
        return view('pages/products/list', $this->data);
    }
    public function product_add()
    {
        if ($this->request->getMethod() == 'post') {
            $imageFile = $this->request->getFile('image');  // Ambil gambar
            $newImageName = $imageFile->getRandomName(); // Generate nama file baru
            $imageFile->move('public/img', $newImageName); // Pindahkan ke folder img

            extract($this->request->getPost());
            $udata = [];
            $udata['code'] = $code;
            $udata['name'] = $name;
            $udata['description'] = $description;
            $udata['price'] = $price;
            $udata['image'] = $newImageName;
            $checkCode = $this->prod_model->where('code', $code)->countAllResults();
            if ($checkCode) {
                $this->session->setFlashdata('error', "Product Code Already Taken.");
            } else {
                $save = $this->prod_model->save($udata);
                if ($save) {
                    $this->session->setFlashdata('main_success', "Product Details has been updated successfully.");
                    return redirect()->to('Main/products/');
                } else {
                    $this->session->setFlashdata('error', "Product Details has failed to update.");
                }
            }
        }

        $this->data['page_title'] = "Add New Product";
        return view('pages/products/add', $this->data);
    }
    public function product_edit($id = '')
    {
        if (empty($id))
            return redirect()->to('Main/products');
        if ($this->request->getMethod() == 'post') {
            if (empty($_FILES['image']['error'])) {
                $oldImageName = $this->prod_model->where("id ='{$id}'")->first()['image'];  // Ambil nama file lama
                if (file_exists(base_url() . '/public/img/' . $oldImageName) && !empty($oldImageName)) {
                    unlink(base_url() . '/public/img/' . $oldImageName);    // Hapus gambar lama
                }

                $imageFile = $this->request->getFile('image');  // Ambil gambar
                $newImageName = $imageFile->getRandomName(); // Generate nama file baru
                $imageFile->move('public/img', $newImageName); // Pindahkan ke folder img
            }

            extract($this->request->getPost());
            $udata = [];
            $udata['code'] = $code;
            $udata['name'] = $name;
            $udata['description'] = $description;
            $udata['price'] = $price;
            if (!empty($newImageName)) {
                $udata['image'] = $newImageName;
            }
            $checkCode = $this->prod_model->where('code', $code)->where("id!= '{$id}'")->countAllResults();
            if ($checkCode) {
                $this->session->setFlashdata('error', "Product Code Already Taken.");
            } else {
                $update = $this->prod_model->where('id', $id)->set($udata)->update();
                if ($update) {
                    $this->session->setFlashdata('success', "Product Details has been updated successfully.");
                    return redirect()->to('Main/product_edit/' . $id);
                } else {
                    $this->session->setFlashdata('error', "Product Details has failed to update.");
                }
            }
        }

        $this->data['page_title'] = "Edit Product";
        $this->data['product'] = $this->prod_model->where("id ='{$id}'")->first();
        return view('pages/products/edit', $this->data);
    }

    public function product_delete($id = '')
    {
        if (empty($id)) {
            $this->session->setFlashdata('main_error', "Product Deletion failed due to unknown ID.");
            return redirect()->to('Main/products');
        }
        $oldImageName = $this->prod_model->where("id ='{$id}'")->first()['image'];  // Ambil nama file lama
        if (file_exists(base_url() . '/public/img/' . $oldImageName) && !empty($oldImageName)) {
            unlink(base_url() . '/public/img/' . $oldImageName);    // Hapus gambar lama
        }
        $delete = $this->prod_model->where('id', $id)->delete();
        if ($delete) {
            $this->session->setFlashdata('main_success', "Product has been deleted successfully.");
        } else {
            $this->session->setFlashdata('main_error', "Product Deletion failed due to unknown ID.");
        }
        return redirect()->to('Main/products');
    }
    public function shopping()
    {
        $this->data['page_title'] = "New Transaction";
        $this->data['products'] =  $this->prod_model->findAll();

        return view('pages/shopping/add', $this->data);
    }

    public function save_transaction()
    {
        extract($this->request->getPost());

        $pref = date("Ymd");
        $code = sprintf("%'.05d", 1);
        while (true) {
            if ($this->tran_model->where(" code = '{$pref}{$code}' ")->countAllResults() > 0) {
                $code = sprintf("%'.05d", ceil($code) + 1);
            } else {
                $code = $pref . $code;
                break;
            }
        }

        $data['code'] = $code;
        foreach ($this->request->getPost() as $k => $v) {
            if (!is_array($this->request->getPost($k)) && !in_array($k, ['id'])) {
                $data[$k] = htmlspecialchars($v);
            }
        }
        $save_transaction = $this->tran_model->save($data);
        if ($save_transaction) {
            $transaction_id = $this->tran_model->insertID();
            foreach ($product_id as $k => $v) {
                $data2['transaction_id'] = $transaction_id;
                $data2['product_id'] = $v;
                $data2['price'] = $price[$k];
                $data2['quantity'] = $quantity[$k];
                $this->tran_item_model->save($data2);
            }
            $this->session->setFlashdata('main_success', "Transaction has been saved successfully.");
            return redirect()->to('Main/shopping');
        }
    }
    public function transactions()
    {
        $this->data['page_title'] = "Transactions";
        $this->data['page'] =  !empty($this->request->getVar('page')) ? $this->request->getVar('page') : 1;
        $this->data['perPage'] =  10;
        $this->data['total'] =  $this->tran_model->countAllResults();
        $this->data['transactions'] = $this->tran_model
            ->select(" transactions.*, COALESCE((SELECT SUM(transaction_items.quantity) FROM transaction_items where transaction_id = transactions.id ), 0) as total_items")
            ->paginate($this->data['perPage']);
        $this->data['total_res'] = is_array($this->data['transactions']) ? count($this->data['transactions']) : 0;
        $this->data['pager'] = $this->tran_model->pager;
        return view('pages/shopping/list', $this->data);
    }

    public function transaction_delete($id = '')
    {
        if (empty($id)) {
            $this->session->setFlashdata('main_error', "Transaction Deletion failed due to unknown ID.");
            return redirect()->to('Main/transactions');
        }
        $delete = $this->tran_model->where('id', $id)->delete();
        if ($delete) {
            $this->session->setFlashdata('main_success', "Transaction has been deleted successfully.");
        } else {
            $this->session->setFlashdata('main_error', "Transaction Deletion failed due to unknown ID.");
        }
        return redirect()->to('Main/transactions');
    }
    public function transaction_view($id = '')
    {
        if (empty($id)) {
            $this->session->setFlashdata('main_error', "Transaction Details failed to load due to unknown ID.");
            return redirect()->to('Main/transactions');
        }
        $this->data['page_title'] = "Transactions";
        $this->data['details'] = $this->tran_model->where('id', $id)->first();
        if (!$this->data['details']) {
            $this->session->setFlashdata('main_error', "Transaction Details failed to load due to unknown ID.");
            return redirect()->to('Main/transactions');
        }
        $this->data['items'] = $this->tran_item_model
            ->select("transaction_items.*, CONCAT(products.code,'-',products.name) as product")
            ->where('transaction_id', $id)
            ->join('products', " transaction_items.product_id = products.id ", 'inner')
            ->findAll();
        return view('pages/shopping/view', $this->data);
    }
}
