<div class="box box-primary">
    <div class="box-body">
        <ul class="nav nav-tabs">
            <?php if ($session->role_id == 1) { ?>
                <li class="active"><a data-toggle="tab" href="#menu1">Upload Indent Slip</a></li>
            <?php } ?>
            <?php if ($session->role_id != 5) { ?>
                <li><a data-toggle="tab" href="#menu2">Pending Status</a></li>
                <li><a data-toggle="tab" href="#menu3">Approved Status</a></li>
                <li><a data-toggle="tab" href="#menu4">Rejected Status</a></li>
            <?php } ?>
            <?php if ($session->role_id == 3) { ?>
                <li><a data-toggle="tab" href="#menu5">Quotation</a></li>
            <?php } ?>
            <?php if ($session->role_id == 5) { ?>
                <li class="active"><a data-toggle="tab" href="#menu6">Invoice Request</a></li>
            <?php } ?>
            <?php if ($session->role_id == 4) { ?>
                <li><a data-toggle="tab" href="#menu7">Budget - Rs. <?php echo $budget['budget']-$total['total'] ?></a></li>
            <?php } ?>
        </ul>

        <div class="tab-content">

            <div id="menu1" class="<?php echo $session->role_id == 1 ? "tab-pane fade in active" : "tab-pane" ?>">
                <h3>Indent</h3>
                <div class="text-danger"><?php echo $session->setFlashdata('error'); ?></div>
                <div class="text-success"><?php echo $session->setFlashdata('success'); ?></div>
                <form action="<?php echo site_url('dashboard/add') ?>" method="POST" enctype="multipart/form-data">

                    <div class="col-xs-12">

                        <label for="name" class="control-label"><span class="text-danger">*</span>Indent</label>
                        <div class="form-group">
                            <input type="file" name="intent" class="form-control">
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <label for="name" class="control-label"><span class="text-danger">*</span>Remarks</label>
                        <div class="form-group">
                            <textarea name="comments" placeholder="Remarks" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <input type="submit" value="Submit" class="btn btn-success" />
                        </div>
                    </div>
                </form>
                <p>
            </div>
            <div id="menu2" class="<?php echo $session->role_id > 1 && $session->role_id < 5 ? "tab-pane fade in active" : "tab-pane" ?>">
                <h3>History</h3>
                <table class="table table-hover table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>Indent</th>
                            <th>Remark</th>
                            <?php if($session->role_id ==2 || $session->role_id == 4 || $session->role_id == 3) { ?>
                            <th>Bill</th>
                            <th>Bill Value</th>

<?php }?>                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending as $document) : ?>
                            <tr>
                                <td><a target="_blank" href="<?php echo base_url() . '/public/upload/intent/' . $document['intent']; ?>"><?php echo $document['intent'] ?></a></td>
                                <td><?php echo $document['comments'] ?></td>
                                <td><a target="_blank" href="<?php echo base_url() . '/public/upload/billimage/' . $document['billImage']; ?>"><?php echo $document['billImage'] ?></a></td>
                                <?php if($session->role_id ==2 || $session->role_id == 4 || $session->role_id == 3) { ?>
                            
                                <td><?php echo $document['bill'] ?></td>
                                <td><?php echo $document['created_on'] ?></td>
                            <?php } ?>
                                <?php if ($session->role_id == 1 && $document['pendingFrom'] == 2) { ?>
                                    <td>
                                        <form id="reupload" method="post" enctype="multipart/form-data" action="<?php echo site_url('dashboard/reupload') ?>">
                                            <label>
                                                Reupload
                                                <input type="file" name="intent" />
                                                <input type="hidden" name="documentId" value="<?php echo $document['document_id'] ?>" />
                                                <input type="submit" value="Submit" class="btn btn-small btn-success" />
                                            </label>
                                        </form>
                                    </td>
                                <?php } ?>
                                <?php if ($session->role_id == 2 && $document['pendingFrom'] == 3) { ?>
                                    <td>
                                        <p>HOD Approved the request. Awaiting for Registrar Approval</p>
                                    </td>
                                <?php } ?>
                                <td>
                                    <?php if ($session->role_id == 2 && $document['pendingFrom'] == 2) { ?>
                                        <a href="<?php echo base_url('/dashboard/hod/approve/' . $document['document_id']) ?>"><input type="button" value="Approve" class="btn btn-small btn-success" /></a>
                                        <?php if($document['bill']==0) { ?>
                                         <form action="<?php echo base_url('/dashboard/hod/reject/' . $document['document_id']) ?>" method='POST' />   
                                        <input type="text" name="rejectReason" />
                                         <input type="submit" value="Reject" class="btn btn-small btn-danger" />
                                    <?php } } ?>
                                </td>
                                <?php if ($session->role_id == 3 && $document['pendingFrom'] == 3 &&  $document['quotation'] == null) { ?>
                                    <td>
                                        <form id="reupload" method="post" enctype="multipart/form-data" action="<?php echo site_url('dashboard/upload/quotation') ?>">
                                            <label>
                                                Upload quotation
                                                <input type="file" name="quotation" />
                                                <input type="hidden" name="documentId" value="<?php echo $document['document_id'] ?>" />
                                                <input type="submit" value="Submit" class="btn btn-small btn-success" />
                                            </label>
                                        </form>
                                    </td>
                                <?php } ?>
                                <?php if ($session->role_id == 3 && $document['pendingFrom'] == 3 && $document['quotation'] != '') { ?>
                                    <td><a target="_blank" href="<?php echo base_url() . '/public/upload/quotation/' . $document['quotation']; ?>"><?php echo $document['quotation'] ?></a>
                                    <form id="reupload" method="post" enctype="multipart/form-data" action="<?php echo site_url('dashboard/upload/comparative') ?>">
                                            <label>
                                                Upload comparative statement
                                                <input type="file" name="comparative" />
                                                <input type="hidden" name="documentId" value="<?php echo $document['document_id'] ?>" />
                                                <input type="submit" value="Submit" class="btn btn-small btn-success" />
                                            </label>
                                        </form>
                                </td>
                                <?php } ?>
                                <?php if ($session->role_id == 4 && $document['pendingFrom'] == 4 && $document['comparative'] != '') { ?>
                                    <td>Comparative Statement : <a target="_blank" href="<?php echo base_url() . '/public/upload/comparative/' . $document['comparative']; ?>"><?php echo $document['comparative'];?></a>
                                    <form id="reupload" method="post" enctype="multipart/form-data" action="<?php echo site_url('dashboard/selectcompany') ?>">
                                            <label>
                                                Select Company
                                                <select name="company">
                                                    <?php foreach($companies as $company) { ?>
                                                        <option value="<?php echo $company['admin_id'] ?>"><?php echo $company['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <br>
                                                <label>
                                                    Bill Value
                                                <input type="number" name="bill" max=<?php echo $budget['budget'] - $total['total'] ?> required />
                                                </label>
                                                <input type="file" name="billimage" />
                                                <input type="hidden" name="documentId"value="<?php echo $document['document_id']  ?>" />
                                                <input type="submit" class="btn btn-success" value="SUBMIT" />
                                            </label>
                                        </form>
                                </td>
                                <?php } ?>
                                <?php if ($session->role_id == 4 && $document['pendingFrom'] == 2 && $document['comparative'] != '' && $document['principalApproval'] == true) { ?>
                                   
                                    <td>Comparative Statement : <a target="_blank" href="<?php echo base_url() . '/public/upload/comparative/' . $document['comparative']; ?>"><?php echo $document['comparative'] ?></a>
                                    <?php foreach($companies as $company) { 
                                        if($company['admin_id'] == $document['company_id']) {
                                            echo "</br> Selected company : ". $company['name'] ;
                                        } } ?>
                                </td>
                                </td>
                                <?php } ?>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div id="menu3" class="tab-pane fade">
                <h3>History</h3>
                <table class="table table-hover table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>Indent</th>
                            <?php if($session->role_id ==2 || $session->role_id == 4 || $session->role_id == 3) { ?>
                            <th>Bill</th>
                            <th>Bill Value</th>
                            <?php } ?>
                            <th>Remark</th>
                            <th>Created On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($approved as $document) : ?>
                            <tr>
                                <td><a target="_blank" href="<?php echo base_url() . '/public/upload/intent/' . $document['intent']; ?>"><?php echo $document['intent'] ?></a></td>
                                <?php if($session->role_id ==2 || $session->role_id == 4 || $session->role_id == 3) { ?>
                                <td><a target="_blank" href="<?php echo base_url() . '/public/upload/billimage/' . $document['billImage']; ?>"><?php echo $document['billImage'] ?></a></td>
                                <td><?php echo $document['bill'] ?></td>
                                <?php } ?>
                                <td><?php echo $document['comments'] ?></td>
                                <td><?php echo $document['created_on'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div id="menu4" class="tab-pane fade">
                <h3>History</h3>
                <table class="table table-hover table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>Indent</th>
                            <th>Remark</th>
                            <th>Reason</th>
                            <th>Created On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rejected as $document) : ?>
                            <tr>
                                <td><a target="_blank" href="<?php echo base_url() . '/public/upload/intent/' . $document['intent']; ?>"><?php echo $document['intent'] ?></a></td>
                                <td><?php echo $document['comments'] ?></td>
                                <td><?php echo $document['rejectReason'] ?></td>
                                <td><?php echo $document['created_on'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

            <div id="menu5" class="tab-pane fade">
                <h3>History</h3>
                <table class="table table-hover table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>Indent</th>
                            <th>Quotation</th>
                            <th>Company</th>
                            <th>Invoice</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($quotation as $document) : ?>
                            <tr>
                                <td><a target="_blank" href="<?php echo base_url() . '/public/upload/intent/' . $document['intent']; ?>"><?php echo $document['intent'] ?></a></td>
                                <td><a target="_blank" href="<?php echo base_url() . '/public/upload/quotation/' . $document['quotation']; ?>"><?php echo $document['quotation'] ?></a></td>
                                <td><?php echo $document['name'] ?></td>
                                <td><a target="_blank" href="<?php echo base_url() . '/public/upload/invoice/' . $document['invoice']; ?>"><?php echo $document['invoice'] ?></a></td>

                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

            <div id="menu6" class="<?php echo $session->role_id == 5 ? "tab-pane fade in active" : "tab-pane" ?>">
                <h3>History</h3>
                <table class="table table-hover table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>Indent</th>
                            <th>Quotation</th>
                            <th>Invoice</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($quotation as $document) : ?>
                        <tr>
                                <td><a target="_blank" href="<?php echo base_url() . '/public/upload/intent/' . $document['intent']; ?>"><?php echo $document['intent'] ?></a></td>
                                <td><a target="_blank" href="<?php echo base_url() . '/public/upload/quotation/' . $document['quotation']; ?>"><?php echo $document['quotation'] ?></a></td>
                                <?php if ($document['invoice'] == '') { ?>
                                    <td>
                                        <form id="reupload" method="post" enctype="multipart/form-data" action="<?php echo site_url('dashboard/upload/invoice') ?>">
                                            <label>
                                                Upload
                                                <input type="file" name="invoice" />
                                                <input type="hidden" name="quotationId" value="<?php echo $document['quotation_id'] ?>" />
                                                <input type="submit" value="Submit" class="btn btn-small btn-success" />
                                            </label>
                                        </form>
                                    </td>
                                <?php } ?>
                                <?php if ($document['invoice'] != '') { ?>
                                    <td><a target="_blank" href="<?php echo base_url() . '/public/upload/invoice/' . $document['invoice']; ?>"><?php echo $document['invoice'] ?></a></td>
                                <?php } ?>

                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div id="menu7" class="tab-pane fade">
                <h3>Budget</h3>
                <div>
                    <form action="<?php echo site_url('dashboard/budget') ?>" method="post">
                        <div class="col-xs-12">
                        <div class="form-group">
                            <input type="number"  name="budget" required />
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Submit" class="btn btn-success" />
                        </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>