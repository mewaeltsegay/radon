<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 8/4/2020
 * Time: 9:21 PM
 */
include "include/divisions/header.php";
include "include/divisions/side_nav.php";
include "include/divisions/top_nav.php";
?>
    <div class="container-fluid mt--7">
    <div class="mb-2">
        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
            <li class="nav-item ">
                <a class="nav-link mb-sm-3 mb-md-0 active card" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="fas fa-map-marker-alt"></i>Locations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link mb-sm-3 mb-md-0 card" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false"><i class="fas fa-plus"></i>New Location</a>
            </li>
        </ul>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                    <div class="table-responsive">
                        <div>
                            <table class="table align-items-center">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">
                                        Name
                                    </th>
                                    <th scope="col">
                                        Description
                                    </th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody class="list">
                                <?php $fun->populateLocations();?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                    <form method="post" action="admin/processLocation.php">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="label">Location</label>
                                    <input type="text" class="form-control" name="location" placeholder="Example:Office-11 or IT-office or Z1-A-001" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="label" for="description">Description</label>
                                    <textarea class="form-control" type="text" id="description" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Update Location</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form id="loc-form" method="post" action="admin/updateLocation.php">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="label">Location</label>
                                    <input type="text" class="form-control" id="loc" name="location" placeholder="Example:Office-11 or IT-office or Z1-A-001" required>
                                    <input type="text" class="form-control" id="id" name="id" placeholder="Example:Office-11 or IT-office or Z1-A-001" hidden>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="label" for="descript">Description</label>
                                    <textarea class="form-control" type="text" id="descript" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button form="loc-form" type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

<?php
include "include/divisions/footer.php";
