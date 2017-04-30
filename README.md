# EMS
Employee Management System based on ThinkPHP
#########################################################################################
#
#                                     安装说明
# Author: liebert
# Date  : 2017/03/11
#########################################################################################

# 1.将文件拷贝至Web根目录下，不要修改任何文件；

# 2.在浏览器中输入URL，按照提示进行安装配置；

# 3.安装完成后，可删除“App/”目录下的install文件夹；

# 4.输入用户名、密码登录系统。


#########################################################################################
#
#                                     更新说明
# A : Add
# D : Delete
# U : Update
#########################################################################################

#########################################################################################
#UPDATE 01

# 2017.03.17
  1.修复了安装部署时管理员默认头像配置失败bug。
    /App/Install/Conf/config.php  -U-

  2.修复了用户编辑时用户角色更新失败bug
    /App/Admin/Controller/UserController.class.php  -U-


  3.为组织管理模块添加删除功能

    /App/Admin/Controller/EmployeeController.class.php  -U-
    /App/Admin/View/Employee/organization.html  -U-
    /Public/js/admin/employee/organization.js  -U-

  3.完成了数据库备份恢复功能。
    数据表备份
    数据表优化
    数据表修复
    数据表恢复
    /App/Admin/Controller/DatabaseController.class.php  -U-
    /ThinkPHP/Library/Vendor/LEOS  -D-
    /ThinkPHP/Library/Org/Util/Database.class.php  -A-
    /Public/js/admin/database/export.js  -U-
    /Public/js/admin/database/import.js  -U-
    /App/Admin/View/Database/export.html  -U-
    /App/Admin/View/Database/import.html  -U-

  4.员工工资汇总视图实现进行变更
    删除了数据库 [tablePrefix]employee_wages_sum_view
    /App/Report/Model/EmployeeWagesSumViewModel.class.php  -A-
#########################################################################################
#UPDATE 02

# 2017.03.25
    1.修复了员工类别编辑bug。
      /Public/js/admin/employee/worker-category.js  -U-

# 2017.03.29
    1.重新对报表打印界面进行布局
    /App/Admin/View/Report/print-one-reports.html  -U-
    2.修改了数据库
    /App/Install/Data/update.sql  -U-

    3.修改了员工信息录入,多字段排序
    /App/Admin/Controller/EmployeeController.class.php  -U-
    /App/Admin/Model/EmployeeWorkerModel.class.php  -U-
    /App/Admin/Model/EmployeeWorkerViewModel.class.php  -D-
    /Public/js/admin/employee/worker.js  -U-

    4.修改了汇总表单模块
    /App/Admin/Model/WorkSumViewModel.class.php  -U-
    /Public/js/admin/employee/work-sum.js  -U-

    5.修改了权限规则不能删除bug
    /Public/js/admin/rule/index.js  -U-

    6.删除了组织管理模块
    /App/Admin/View/Employee/organization.html  -D-
    /App/Admin/View/Employee/organization-form.html  -D-
    /Public/js/admin/employee/organization.js  -D-

    7.删除了类别管理模块
    /App/Admin/View/Employee/worker-category.html  -D-
    /App/Admin/View/Employee/worker-category-form.html  -D-
    /Public/js/admin/employee/worker-category.js  -D-

    8.添加了扩展信息录入，支持多字段排序
    /App/Admin/View/Employee/worker-extend.html  -A-
    /Public/js/admin/employee/worker-extend.js  -A-

    9.添加了数据库备份恢复时终止执行的提示，防止用户强行关闭页面导致备份恢复失败
    /Public/js/admin/database/import.js  -U-
    /Public/js/admin/database/export.js  -U-

    10.添加了当前登陆用户修改资料功能
    /App/Admin/View/Index/index.html  -U-
    /App/Admin/View/Index/user-setting-form.html  -A-
    /Public/js/admin/index.js  -D-
    /Public/js/admin/index/index.js  -A-

    11.修复了权限规则查看列表界面bug
    /App/Admin/View/Rule/index.html  -U-

    12.修复了用户角色界面bug
    /Public/js/admin/role/index.js  -U-

    13.修改了数据库更新函数
    /App/Install/Common/function.php  -U-

