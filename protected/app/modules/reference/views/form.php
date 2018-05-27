<div class="content-wrapper">
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <?php echo $breadcrumbs; ?>
                <h4><?php echo ($data) ? lang('merchant_edit_heading') : lang('merchant_add_heading'); ?></h4>
            </div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo site_url('merchants'); ?>" class="btn btn-link btn-float has-text"><i class="icon-list3 text-primary"></i><span><?php echo lang('merchant_list_heading'); ?></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <form action="<?php echo site_url('merchants/save'); ?>" method="post" class="form-horizontal" id="form">
                    <input type="hidden" name="id" value="<?php echo set_value('id', ($data) ? encode($data->id) : ''); ?>">
                    <input type="hidden" name="lat" id="lat" value="<?php echo ($data) ? $data->lat : ''; ?>">
                    <input type="hidden" name="lng" id="lng" value="<?php echo ($data) ? $data->lng : ''; ?>">
                    <div class="panel panel-flat">
                        <div class="panel-body">
                            <div class="tabbable">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#data" data-toggle="tab"><?php echo lang('merchant_form_data_tabs'); ?></a></li>
                                    <li class=""><a href="#address" data-toggle="tab"><?php echo lang('merchant_form_address_tabs'); ?></a></li>
                                    <li class=""><a href="#owner" data-toggle="tab"><?php echo lang('merchant_form_owner_tabs'); ?></a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="data">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="name"><?php echo lang('merchant_form_name_label'); ?></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" required="" id="name" name="name" placeholder="<?php echo lang('merchant_form_name_placeholder'); ?>" value="<?php echo ($data) ? $data->name : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo lang('merchant_form_description_label'); ?></label>
                                            <div class="col-md-9">
                                                <textarea cols="30" rows="2" class="form-control" id="description" name="description" placeholder="<?php echo lang('merchant_form_description_placeholder'); ?>"><?php echo ($data) ? $data->description : ''; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="username"><?php echo lang('merchant_form_username_label'); ?></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" <?php echo ($data) ? 'disabled' : 'required'; ?> id="username" name="username" value="<?php echo ($data) ? $data->username : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo lang('merchant_form_group_label'); ?></label>
                                            <div class="col-md-4">
                                                <select class="bootstrap-select"  name="group" required="" data-live-search="true" data-width="100%">
                                                    <option value=""></option>
                                                    <?php if ($groups) { ?>
                                                        <?php foreach ($groups->result() as $group) { ?>
                                                            <option value="<?php echo $group->id; ?>" <?php echo ($data) ? ($data->group == $group->id) ? 'selected' : '' : ''; ?>><?php echo $group->name; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="telephone"><?php echo lang('merchant_form_telephone_label'); ?></label>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="telephone" value="<?php echo ($data) ? $data->telephone : ''; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane " id="address">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo lang('merchant_form_address_label'); ?></label>
                                            <div class="col-md-9">
                                                <textarea cols="30" rows="2" class="form-control" id="address" name="address"><?php echo ($data) ? $data->address : ''; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="province"><?php echo lang('merchant_form_province_label'); ?></label>
                                            <div class="col-md-4">
                                                <select class="bootstrap-select"  name="province" id="province" data-live-search="true" data-width="100%">
                                                    <option value=""></option>
                                                    <?php if ($provinces) { ?>
                                                        <?php foreach ($provinces->result() as $province) { ?>
                                                            <option value="<?php echo $province->id; ?>" <?php echo ($data) ? ($data->province == $province->id) ? 'selected' : '' : ''; ?>><?php echo $province->name; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="city"><?php echo lang('merchant_form_city_label'); ?></label>
                                            <div class="col-md-4">
                                                <select class="bootstrap-select"  name="city" id="city" data-live-search="true" data-width="100%">
                                                    <option value=""></option>
                                                    <?php if ($cities) { ?>
                                                        <?php foreach ($cities->result() as $city) { ?>
                                                            <option value="<?php echo $city->id; ?>" <?php echo ($data) ? ($data->city == $city->id) ? 'selected' : '' : ''; ?>><?php echo $city->name; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="district"><?php echo lang('merchant_form_district_label'); ?></label>
                                            <div class="col-md-4">
                                                <select class="bootstrap-select"  name="district" id="district" data-live-search="true" data-width="100%">
                                                    <option value=""></option>
                                                    <?php if ($districts) { ?>
                                                        <?php foreach ($districts->result() as $district) { ?>
                                                            <option value="<?php echo $district->id; ?>" <?php echo ($data) ? ($data->district == $district->id) ? 'selected' : '' : ''; ?>><?php echo $district->name; ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"><?php echo lang('merchant_form_maps_label'); ?></label>
                                            <div class="col-md-9">
                                                <script type="text/javascript">
                                                    var centreGot = false;
                                                </script>
                                                <?php echo $map['js']; ?>
                                                <input class="form-control" id="search-location">
                                                <?php echo $map['html']; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane " id="owner">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="fullname"><?php echo lang('merchant_form_fullname_label'); ?></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" required="" name="fullname" value="<?php echo ($data) ? $data->fullname : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="email"><?php echo lang('merchant_form_email_label'); ?></label>
                                            <div class="col-md-9">
                                                <input type="email" class="form-control" <?php echo (!$data) ? 'required' : 'disabled' ?> name="email" value="<?php echo ($data) ? $data->email : ''; ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="password"><?php echo lang('merchant_form_password_label'); ?></label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" <?php echo (!$data) ? 'required' : '' ?> name="password">
                                                <?php if ($data) { ?>
                                                    <span class="help-block"><?php echo lang('merchant_form_password_update_help'); ?></span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <div class="heading-elements action-left">
                                <a class="btn btn-default" href="<?php echo site_url('merchants'); ?>"><?php echo lang('button_cancel'); ?></a>
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary"><?php echo lang('button_save'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>