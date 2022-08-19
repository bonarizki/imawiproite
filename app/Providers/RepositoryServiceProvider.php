<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //resignation
        $this->app->bind('App\Repository\Resignation\Resign\Interfaces\ResignInterfaces','App\Repository\Resignation\Resign\ResignRepository');
        $this->app->bind('App\Repository\Resignation\Status\Interfaces\StatusInterfaces','App\Repository\Resignation\Status\StatusRepository');
        $this->app->bind('App\Repository\Resignation\Approve\Interfaces\ApproveInterfaces','App\Repository\Resignation\Approve\ApproveRepository');
        $this->app->bind('App\Repository\Resignation\Clearance\Interfaces\ClearanceInterfaces','App\Repository\Resignation\Clearance\ClearanceRepository');
        $this->app->bind('App\Repository\Resignation\Dashboard\Interfaces\DashboardInterfaces','App\Repository\Resignation\Dashboard\DashboardRepository');
        $this->app->bind('App\Repository\Resignation\Report\Interfaces\ReportInterfaces','App\Repository\Resignation\Report\ReportRepository');
        $this->app->bind('App\Repository\Resignation\AccessPosition\Interfaces\AccessPositionInterfaces','App\Repository\Resignation\AccessPosition\AccessPositionRepository');

        //dashboard
        $this->app->bind('App\Repository\Dashboard\Module\Interfaces\ModuleInterfaces','App\Repository\Dashboard\Module\ModuleRepository');
        $this->app->bind('App\Repository\Dashboard\ModuleAdmin\Interfaces\ModuleAdminInterfaces','App\Repository\Dashboard\ModuleAdmin\ModuleAdminRepository');
        $this->app->bind('App\Repository\Dashboard\Plugin\Interfaces\PluginYearInterfaces','App\Repository\Dashboard\Plugin\PluginYearRepository');
        $this->app->bind('App\Repository\Dashboard\Plugin\Interfaces\PluginMonthInterfaces','App\Repository\Dashboard\Plugin\PluginMonthRepository');
        $this->app->bind('App\Repository\Dashboard\Plugin\Interfaces\PluginPeriodInterfaces','App\Repository\Dashboard\Plugin\PluginPeriodRepository');
        $this->app->bind('App\Repository\Dashboard\Plugin\Interfaces\PluginVersionInterfaces','App\Repository\Dashboard\Plugin\PluginVersionRepository');
        $this->app->bind('App\Repository\Dashboard\Plugin\Interfaces\PluginSettingSystemInterfaces','App\Repository\Dashboard\Plugin\PluginSystemSettingRepository');
        $this->app->bind('App\Repository\Dashboard\Menu\Interfaces\MenuInterfaces','App\Repository\Dashboard\Menu\MenuRepository');
        $this->app->bind('App\Repository\Dashboard\User\Interfaces\UserInterfaces','App\Repository\Dashboard\User\UserRepository');
        $this->app->bind('App\Repository\Dashboard\ApprovalMatrix\Interfaces\ApprovalMatrixInterfaces','App\Repository\Dashboard\ApprovalMatrix\ApprovalMatrixRepository');
        $this->app->bind('App\Repository\Dashboard\Department\Interfaces\DepartmentInterfaces','App\Repository\Dashboard\Department\DepartmentRepository');
        $this->app->bind('App\Repository\Dashboard\Title\Interfaces\TitleInterfaces','App\Repository\Dashboard\Title\TitleRepository');
        $this->app->bind('App\Repository\Dashboard\GradeGroup\Interfaces\GradeGroupInterfaces','App\Repository\Dashboard\GradeGroup\GradeGroupRepository');
        $this->app->bind('App\Repository\Dashboard\Grade\Interfaces\GradeInterfaces','App\Repository\Dashboard\Grade\GradeRepository');
        $this->app->bind('App\Repository\Dashboard\Type\Interfaces\TypeInterfaces','App\Repository\Dashboard\Type\TypeRepository');
        $this->app->bind('App\Repository\Dashboard\AgeCategory\Interfaces\AgeCategoryInterfaces','App\Repository\Dashboard\AgeCategory\AgeCategoryRepository');

        //Training
        $this->app->bind('App\Repository\Training\Menu\Interfaces\MenuInterfaces','App\Repository\Training\Menu\MenuRepository');
        $this->app->bind('App\Repository\Training\AccessPosition\Interfaces\AccessPositionInterfaces','App\Repository\Training\AccessPosition\AccessPositionRepository');
        $this->app->bind('App\Repository\Training\Dashboard\Interfaces\DashboardInterfaces','App\Repository\Training\Dashboard\DashboardRepository');
        $this->app->bind('App\Repository\Training\Vendor\Interfaces\VendorInterfaces','App\Repository\Training\Vendor\VendorRepository');
        $this->app->bind('App\Repository\Training\Category\Interfaces\CategoryInterfaces','App\Repository\Training\Category\CategoryRepository');
        $this->app->bind('App\Repository\Training\Request\Interfaces\TrainingRequestInterfaces','App\Repository\Training\Request\TrainingRequestRepository');
        $this->app->bind('App\Repository\Training\Status\Interfaces\TrainingStatusInterfaces','App\Repository\Training\Status\TrainingStatusRepository');
        $this->app->bind('App\Repository\Training\Approval\Interfaces\ApprovalInterfaces','App\Repository\Training\Approval\ApprovalRepository');
        $this->app->bind('App\Repository\Training\MyTraining\Interfaces\MyTrainingInterfaces','App\Repository\Training\MyTraining\MyTrainingRepository');
        $this->app->bind('App\Repository\Training\Report\Interfaces\TrainingReportInterfaces','App\Repository\Training\Report\TrainingReportRepository');
        $this->app->bind('App\Repository\Training\TrainingMethod\Interfaces\TrainingMethodInterfaces','App\Repository\Training\TrainingMethod\TrainingMethodRepository');

        //Ticketing
        $this->app->bind('App\Repository\Ticketing\Menu\Interfaces\MenuInterfaces','App\Repository\Ticketing\Menu\MenuRepository');
        $this->app->bind('App\Repository\Ticketing\AccessPosition\Interfaces\AccessPositionInterfaces','App\Repository\Ticketing\AccessPosition\AccessPositionRepository');
        $this->app->bind('App\Repository\Ticketing\Dashboard\Interfaces\DashboardInterfaces','App\Repository\Ticketing\Dashboard\DashboardRepository');
        $this->app->bind('App\Repository\Ticketing\Priority\Interfaces\PriorityInterfaces','App\Repository\Ticketing\Priority\PriorityRepository');
        $this->app->bind('App\Repository\Ticketing\TicketingType\Interfaces\TicketingTypeInterfaces','App\Repository\Ticketing\TicketingType\TicketingTypeRepository');
        $this->app->bind('App\Repository\Ticketing\ApprovalType\Interfaces\ApprovalTypeInterfaces','App\Repository\Ticketing\ApprovalType\ApprovalTypeRepository');
        $this->app->bind('App\Repository\Ticketing\RequestTicketing\Interfaces\RequestTicketingInterfaces','App\Repository\Ticketing\RequestTicketing\RequestTicketingRepository');
        $this->app->bind('App\Repository\Ticketing\TicketingStatus\Interfaces\TicketingStatusInterfaces','App\Repository\Ticketing\TicketingStatus\TicketingStatusRepository');
        $this->app->bind('App\Repository\Ticketing\Approve\Interfaces\ApproveInterfaces','App\Repository\Ticketing\Approve\ApproveRepository');
        $this->app->bind('App\Repository\Ticketing\UploadFile\Interfaces\UploadFileInterfaces','App\Repository\Ticketing\UploadFile\UploadFileRepository');
        $this->app->bind('App\Repository\Ticketing\ProductCategory\Interfaces\ProductCategoryInterfaces','App\Repository\Ticketing\ProductCategory\ProductCategoryRepository');
        $this->app->bind('App\Repository\Ticketing\ProductSubCategory\Interfaces\ProductSubCategoryInterfaces','App\Repository\Ticketing\ProductSubCategory\ProductSubCategoryRepository');
        $this->app->bind('App\Repository\Ticketing\SystemApplications\Interfaces\SystemApplicationsInterfaces','App\Repository\Ticketing\SystemApplications\SystemApplicationsRepository');

        //Koperasi
        $this->app->bind('App\Repository\Koperasi\Dashboard\Interfaces\DashboardInterfaces','App\Repository\Koperasi\Dashboard\DashboardRepository');
        $this->app->bind('App\Repository\Koperasi\Menu\Interfaces\MenuInterfaces','App\Repository\Koperasi\Menu\MenuRepository');
        $this->app->bind('App\Repository\Koperasi\AccessPosition\Interfaces\AccessPositionInterfaces','App\Repository\Koperasi\AccessPosition\AccessPositionRepository');
        $this->app->bind('App\Repository\Koperasi\Product\Interfaces\ProductInterfaces','App\Repository\Koperasi\Product\ProductRepository');
        $this->app->bind('App\Repository\Koperasi\ProductSetting\Interfaces\ProductSettingInterfaces','App\Repository\Koperasi\ProductSetting\ProductSettingRepository');
        $this->app->bind('App\Repository\Koperasi\OrderLimit\Interfaces\OrderLimitInterfaces','App\Repository\Koperasi\OrderLimit\OrderLimitRepository');
        $this->app->bind('App\Repository\Koperasi\Order\Interfaces\OrderInterfaces','App\Repository\Koperasi\Order\OrderRepository');
        $this->app->bind('App\Repository\Koperasi\History\Interfaces\HistoryInterfaces','App\Repository\Koperasi\History\HistoryRepository');
        $this->app->bind('App\Repository\Koperasi\Member\Interfaces\MemberInterfaces','App\Repository\Koperasi\Member\MemberRepository');
        $this->app->bind('App\Repository\Koperasi\Banner\Interfaces\BannerInterfaces','App\Repository\Koperasi\Banner\BannerRepository');
        
    }
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
