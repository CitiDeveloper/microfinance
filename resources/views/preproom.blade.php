      <form action = "/admin/add_staff_role_account.php" class="form-horizontal" method="post" enctype="multipart/form-data">
            <input type="hidden" name="back_url" value=""> 
                        <input type="hidden" name="add_staff_role" value="1">
            <div class="box-body">
            <div class="form-group">
                
              <label for="inputStaffRoleName" class="col-sm-2 control-label">Staff Role Name</label>                      
              <div class="col-sm-10">
                <input type="text" name="staff_role_name" class="form-control" id="inputStaffRoleName" placeholder="Staff Role Name" value="" required>
             </div>
              
            </div>
             
          </div>
          <div class="box-footer">
              <button type="button" class="btn btn-default"  onClick="parent.location=''">Back</button>
            <button type="submit" class="btn btn-info pull-right">Submit</button>
          </div><!-- /.box-footer -->
        </form>

        Create roles for staff members to define their permissions and access levels within the system.