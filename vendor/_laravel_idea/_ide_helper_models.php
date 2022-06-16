<?php
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** @noinspection PhpUnusedAliasInspection */

namespace App\Models\Attendance {

    use Illuminate\Database\Eloquent\Model;
    use LaravelIdea\Helper\App\Models\Attendance\_IH_AttendanceRoster_C;
    use LaravelIdea\Helper\App\Models\Attendance\_IH_AttendanceRoster_QB;
    use LaravelIdea\Helper\App\Models\Attendance\_IH_AttendanceShift_C;
    use LaravelIdea\Helper\App\Models\Attendance\_IH_AttendanceShift_QB;
    use LaravelIdea\Helper\App\Models\Attendance\_IH_Attendance_C;
    use LaravelIdea\Helper\App\Models\Attendance\_IH_Attendance_QB;
    
    /**
     * @method static _IH_Attendance_QB onWriteConnection()
     * @method _IH_Attendance_QB newQuery()
     * @method static _IH_Attendance_QB on(null|string $connection = null)
     * @method static _IH_Attendance_QB query()
     * @method static _IH_Attendance_QB with(array|string $relations)
     * @method _IH_Attendance_QB newModelQuery()
     * @method static _IH_Attendance_C|Attendance[] all()
     * @mixin _IH_Attendance_QB
     */
    class Attendance extends Model {}
    
    /**
     * @method static _IH_AttendanceRoster_QB onWriteConnection()
     * @method _IH_AttendanceRoster_QB newQuery()
     * @method static _IH_AttendanceRoster_QB on(null|string $connection = null)
     * @method static _IH_AttendanceRoster_QB query()
     * @method static _IH_AttendanceRoster_QB with(array|string $relations)
     * @method _IH_AttendanceRoster_QB newModelQuery()
     * @method static _IH_AttendanceRoster_C|AttendanceRoster[] all()
     * @mixin _IH_AttendanceRoster_QB
     */
    class AttendanceRoster extends Model {}
    
    /**
     * @method static _IH_AttendanceShift_QB onWriteConnection()
     * @method _IH_AttendanceShift_QB newQuery()
     * @method static _IH_AttendanceShift_QB on(null|string $connection = null)
     * @method static _IH_AttendanceShift_QB query()
     * @method static _IH_AttendanceShift_QB with(array|string $relations)
     * @method _IH_AttendanceShift_QB newModelQuery()
     * @method static _IH_AttendanceShift_C|AttendanceShift[] all()
     * @mixin _IH_AttendanceShift_QB
     */
    class AttendanceShift extends Model {}
}

namespace App\Models\BMS {

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Support\Carbon;
    use LaravelIdea\Helper\App\Models\BMS\_IH_AreaObject_C;
    use LaravelIdea\Helper\App\Models\BMS\_IH_AreaObject_QB;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Area_C;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Area_QB;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Building_C;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Building_QB;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Mapping_C;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Mapping_QB;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Master_C;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Master_QB;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Realization_C;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Realization_QB;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Report_C;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Report_QB;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Shift_C;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Shift_QB;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Target_C;
    use LaravelIdea\Helper\App\Models\BMS\_IH_Target_QB;
    
    /**
     * @property int $id
     * @property int $building_id
     * @property int $service_id
     * @property string $name
     * @property int|null $employee_id
     * @property string $code
     * @property string|null $description
     * @property string $shift
     * @property int $order
     * @property string $status
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property string|null $qr_file
     * @property _IH_AreaObject_C|AreaObject[] $objects
     * @property-read int $objects_count
     * @method HasMany|_IH_AreaObject_QB objects()
     * @method static _IH_Area_QB onWriteConnection()
     * @method _IH_Area_QB newQuery()
     * @method static _IH_Area_QB on(null|string $connection = null)
     * @method static _IH_Area_QB query()
     * @method static _IH_Area_QB with(array|string $relations)
     * @method _IH_Area_QB newModelQuery()
     * @method static _IH_Area_C|Area[] all()
     * @mixin _IH_Area_QB
     */
    class Area extends Model {}
    
    /**
     * @property int $id
     * @property int $service_id
     * @property int $building_id
     * @property int $area_id
     * @property int $object_id
     * @property int|null $employee_id
     * @property string $name
     * @property string|null $description
     * @property string $code
     * @property string $shift
     * @property string $qr
     * @property int $order
     * @property string $status
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static _IH_AreaObject_QB onWriteConnection()
     * @method _IH_AreaObject_QB newQuery()
     * @method static _IH_AreaObject_QB on(null|string $connection = null)
     * @method static _IH_AreaObject_QB query()
     * @method static _IH_AreaObject_QB with(array|string $relations)
     * @method _IH_AreaObject_QB newModelQuery()
     * @method static _IH_AreaObject_C|AreaObject[] all()
     * @mixin _IH_AreaObject_QB
     */
    class AreaObject extends Model {}
    
    /**
     * @property int $id
     * @property string $code
     * @property string $name
     * @property int $region_id
     * @property int $type_id
     * @property string|null $address
     * @property string $status
     * @property string|null $services
     * @property string|null $photo
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static _IH_Building_QB onWriteConnection()
     * @method _IH_Building_QB newQuery()
     * @method static _IH_Building_QB on(null|string $connection = null)
     * @method static _IH_Building_QB query()
     * @method static _IH_Building_QB with(array|string $relations)
     * @method _IH_Building_QB newModelQuery()
     * @method static _IH_Building_C|Building[] all()
     * @mixin _IH_Building_QB
     */
    class Building extends Model {}
    
    /**
     * @property int $id
     * @property int $employee_id
     * @property int $region_id
     * @property int $building_id
     * @property string $service
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static _IH_Mapping_QB onWriteConnection()
     * @method _IH_Mapping_QB newQuery()
     * @method static _IH_Mapping_QB on(null|string $connection = null)
     * @method static _IH_Mapping_QB query()
     * @method static _IH_Mapping_QB with(array|string $relations)
     * @method _IH_Mapping_QB newModelQuery()
     * @method static _IH_Mapping_C|Mapping[] all()
     * @mixin _IH_Mapping_QB
     */
    class Mapping extends Model {}
    
    /**
     * @property int $id
     * @property int $service_id
     * @property int $object_id
     * @property int $target_id
     * @property int $category_id
     * @property string $name
     * @property string $code
     * @property string $control_type
     * @property string|null $control_parameter
     * @property int|null $control_unit_id
     * @property int|null $interval_id
     * @property string|null $description
     * @property int $order
     * @property string $status
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static _IH_Master_QB onWriteConnection()
     * @method _IH_Master_QB newQuery()
     * @method static _IH_Master_QB on(null|string $connection = null)
     * @method static _IH_Master_QB query()
     * @method static _IH_Master_QB with(array|string $relations)
     * @method _IH_Master_QB newModelQuery()
     * @method static _IH_Master_C|Master[] all()
     * @mixin _IH_Master_QB
     */
    class Master extends Model {}
    
    /**
     * @property int $id
     * @property int $employee_id
     * @property int $building_id
     * @property int $service_id
     * @property int $area_id
     * @property int $object_id
     * @property int $shift_id
     * @property int $activity_id
     * @property string|null $control_type
     * @property string|null $control_result
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static _IH_Realization_QB onWriteConnection()
     * @method _IH_Realization_QB newQuery()
     * @method static _IH_Realization_QB on(null|string $connection = null)
     * @method static _IH_Realization_QB query()
     * @method static _IH_Realization_QB with(array|string $relations)
     * @method _IH_Realization_QB newModelQuery()
     * @method static _IH_Realization_C|Realization[] all()
     * @mixin _IH_Realization_QB
     */
    class Realization extends Model {}
    
    /**
     * @property int $id
     * @property int $employee_id
     * @property int $building_id
     * @property int $area_id
     * @property int $service_id
     * @property Carbon $date
     * @property string $description
     * @property string|null $location
     * @property string $time
     * @property string|null $image
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static _IH_Report_QB onWriteConnection()
     * @method _IH_Report_QB newQuery()
     * @method static _IH_Report_QB on(null|string $connection = null)
     * @method static _IH_Report_QB query()
     * @method static _IH_Report_QB with(array|string $relations)
     * @method _IH_Report_QB newModelQuery()
     * @method static _IH_Report_C|Report[] all()
     * @mixin _IH_Report_QB
     */
    class Report extends Model {}
    
    /**
     * @property int $id
     * @property int $building_id
     * @property int $service_id
     * @property int $area_id
     * @property string $name
     * @property string $start
     * @property string $end
     * @property string $code
     * @property int|null $interval_id
     * @property string $finish_today
     * @property string|null $description
     * @property string $special
     * @property int $order
     * @property string $status
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static _IH_Shift_QB onWriteConnection()
     * @method _IH_Shift_QB newQuery()
     * @method static _IH_Shift_QB on(null|string $connection = null)
     * @method static _IH_Shift_QB query()
     * @method static _IH_Shift_QB with(array|string $relations)
     * @method _IH_Shift_QB newModelQuery()
     * @method static _IH_Shift_C|Shift[] all()
     * @mixin _IH_Shift_QB
     */
    class Shift extends Model {}
    
    /**
     * @property int $id
     * @property int $service_id
     * @property int $object_id
     * @property string $name
     * @property string $code
     * @property string|null $description
     * @property int $order
     * @property string $status
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property _IH_Master_C|Master[] $masters
     * @property-read int $masters_count
     * @method HasMany|_IH_Master_QB masters()
     * @method static _IH_Target_QB onWriteConnection()
     * @method _IH_Target_QB newQuery()
     * @method static _IH_Target_QB on(null|string $connection = null)
     * @method static _IH_Target_QB query()
     * @method static _IH_Target_QB with(array|string $relations)
     * @method _IH_Target_QB newModelQuery()
     * @method static _IH_Target_C|Target[] all()
     * @mixin _IH_Target_QB
     */
    class Target extends Model {}
}

namespace App\Models\ESS {

    use App\Models\Setting\Master;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Support\Carbon;
    use LaravelIdea\Helper\App\Models\ESS\_IH_AttendanceLeaveMaster_C;
    use LaravelIdea\Helper\App\Models\ESS\_IH_AttendanceLeaveMaster_QB;
    use LaravelIdea\Helper\App\Models\ESS\_IH_AttendanceLeave_C;
    use LaravelIdea\Helper\App\Models\ESS\_IH_AttendanceLeave_QB;
    use LaravelIdea\Helper\App\Models\ESS\_IH_AttendanceOvertime_C;
    use LaravelIdea\Helper\App\Models\ESS\_IH_AttendanceOvertime_QB;
    use LaravelIdea\Helper\App\Models\ESS\_IH_AttendancePermission_C;
    use LaravelIdea\Helper\App\Models\ESS\_IH_AttendancePermission_QB;
    use LaravelIdea\Helper\App\Models\ESS\_IH_AttendanceReimbursement_C;
    use LaravelIdea\Helper\App\Models\ESS\_IH_AttendanceReimbursement_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Master_QB;
    
    /**
     * @property int $id
     * @property int $employee_id
     * @property int $type_id
     * @property string|null $number
     * @property Carbon $date
     * @property Carbon $start_date
     * @property Carbon $end_date
     * @property int $quota
     * @property int $amount
     * @property int $remaining
     * @property string|null $description
     * @property string|null $filename
     * @property int|null $approved_by
     * @property Carbon|null $approved_date
     * @property string|null $approved_note
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property string $approved_status
     * @property AttendanceLeaveMaster $type
     * @method BelongsTo|_IH_AttendanceLeaveMaster_QB type()
     * @method static _IH_AttendanceLeave_QB onWriteConnection()
     * @method _IH_AttendanceLeave_QB newQuery()
     * @method static _IH_AttendanceLeave_QB on(null|string $connection = null)
     * @method static _IH_AttendanceLeave_QB query()
     * @method static _IH_AttendanceLeave_QB with(array|string $relations)
     * @method _IH_AttendanceLeave_QB newModelQuery()
     * @method static _IH_AttendanceLeave_C|AttendanceLeave[] all()
     * @mixin _IH_AttendanceLeave_QB
     */
    class AttendanceLeave extends Model {}
    
    /**
     * @property int $id
     * @property string $name
     * @property int $quota
     * @property string|null $description
     * @property Carbon $start_date
     * @property Carbon $end_date
     * @property int|null $working_life
     * @property string $gender
     * @property int|null $location_id
     * @property string $status
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static _IH_AttendanceLeaveMaster_QB onWriteConnection()
     * @method _IH_AttendanceLeaveMaster_QB newQuery()
     * @method static _IH_AttendanceLeaveMaster_QB on(null|string $connection = null)
     * @method static _IH_AttendanceLeaveMaster_QB query()
     * @method static _IH_AttendanceLeaveMaster_QB with(array|string $relations)
     * @method _IH_AttendanceLeaveMaster_QB newModelQuery()
     * @method static _IH_AttendanceLeaveMaster_C|AttendanceLeaveMaster[] all()
     * @mixin _IH_AttendanceLeaveMaster_QB
     */
    class AttendanceLeaveMaster extends Model {}
    
    /**
     * @property int $id
     * @property int $employee_id
     * @property string|null $number
     * @property Carbon $date
     * @property Carbon $start_date
     * @property Carbon $end_date
     * @property string $start_time
     * @property string $end_time
     * @property string|null $description
     * @property string|null $filename
     * @property int|null $approved_by
     * @property string $approved_status
     * @property Carbon|null $approved_date
     * @property string|null $approved_note
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property string $duration
     * @method static _IH_AttendanceOvertime_QB onWriteConnection()
     * @method _IH_AttendanceOvertime_QB newQuery()
     * @method static _IH_AttendanceOvertime_QB on(null|string $connection = null)
     * @method static _IH_AttendanceOvertime_QB query()
     * @method static _IH_AttendanceOvertime_QB with(array|string $relations)
     * @method _IH_AttendanceOvertime_QB newModelQuery()
     * @method static _IH_AttendanceOvertime_C|AttendanceOvertime[] all()
     * @mixin _IH_AttendanceOvertime_QB
     */
    class AttendanceOvertime extends Model {}
    
    /**
     * @property int $id
     * @property int $employee_id
     * @property int $category_id
     * @property string|null $number
     * @property Carbon $date
     * @property Carbon $start_date
     * @property Carbon $end_date
     * @property string|null $description
     * @property string|null $filename
     * @property int|null $approved_by
     * @property string $approved_status
     * @property Carbon|null $approved_date
     * @property string|null $approved_note
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Master $category
     * @method BelongsTo|_IH_Master_QB category()
     * @method static _IH_AttendancePermission_QB onWriteConnection()
     * @method _IH_AttendancePermission_QB newQuery()
     * @method static _IH_AttendancePermission_QB on(null|string $connection = null)
     * @method static _IH_AttendancePermission_QB query()
     * @method static _IH_AttendancePermission_QB with(array|string $relations)
     * @method _IH_AttendancePermission_QB newModelQuery()
     * @method static _IH_AttendancePermission_C|AttendancePermission[] all()
     * @mixin _IH_AttendancePermission_QB
     */
    class AttendancePermission extends Model {}
    
    /**
     * @property int $id
     * @property int $employee_id
     * @property string $number
     * @property Carbon $date
     * @property int $category_id
     * @property string|null $description
     * @property string|null $filename
     * @property string $value
     * @property int|null $approved_by
     * @property Carbon|null $approved_date
     * @property string|null $approved_note
     * @property string|null $approved_status
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Master $category
     * @method BelongsTo|_IH_Master_QB category()
     * @method static _IH_AttendanceReimbursement_QB onWriteConnection()
     * @method _IH_AttendanceReimbursement_QB newQuery()
     * @method static _IH_AttendanceReimbursement_QB on(null|string $connection = null)
     * @method static _IH_AttendanceReimbursement_QB query()
     * @method static _IH_AttendanceReimbursement_QB with(array|string $relations)
     * @method _IH_AttendanceReimbursement_QB newModelQuery()
     * @method static _IH_AttendanceReimbursement_C|AttendanceReimbursement[] all()
     * @mixin _IH_AttendanceReimbursement_QB
     */
    class AttendanceReimbursement extends Model {}
}

namespace App\Models\Employee {

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasOne;
    use Illuminate\Support\Carbon;
    use LaravelIdea\Helper\App\Models\Employee\_IH_EmployeeContact_C;
    use LaravelIdea\Helper\App\Models\Employee\_IH_EmployeeContact_QB;
    use LaravelIdea\Helper\App\Models\Employee\_IH_EmployeeContract_C;
    use LaravelIdea\Helper\App\Models\Employee\_IH_EmployeeContract_QB;
    use LaravelIdea\Helper\App\Models\Employee\_IH_EmployeeEducation_C;
    use LaravelIdea\Helper\App\Models\Employee\_IH_EmployeeEducation_QB;
    use LaravelIdea\Helper\App\Models\Employee\_IH_EmployeeFamily_C;
    use LaravelIdea\Helper\App\Models\Employee\_IH_EmployeeFamily_QB;
    use LaravelIdea\Helper\App\Models\Employee\_IH_EmployeePayroll_C;
    use LaravelIdea\Helper\App\Models\Employee\_IH_EmployeePayroll_QB;
    use LaravelIdea\Helper\App\Models\Employee\_IH_EmployeeTermination_C;
    use LaravelIdea\Helper\App\Models\Employee\_IH_EmployeeTermination_QB;
    use LaravelIdea\Helper\App\Models\Employee\_IH_EmployeeWork_C;
    use LaravelIdea\Helper\App\Models\Employee\_IH_EmployeeWork_QB;
    use LaravelIdea\Helper\App\Models\Employee\_IH_Employee_C;
    use LaravelIdea\Helper\App\Models\Employee\_IH_Employee_QB;
    use LaravelIdea\Helper\App\Models\Employee\_IH_MasterPlacement_C;
    use LaravelIdea\Helper\App\Models\Employee\_IH_MasterPlacement_QB;
    
    /**
     * @property EmployeeContract $contract
     * @method HasOne|_IH_EmployeeContract_QB contract()
     * @property EmployeePayroll $payroll
     * @method HasOne|_IH_EmployeePayroll_QB payroll()
     * @method static _IH_Employee_QB onWriteConnection()
     * @method _IH_Employee_QB newQuery()
     * @method static _IH_Employee_QB on(null|string $connection = null)
     * @method static _IH_Employee_QB query()
     * @method static _IH_Employee_QB with(array|string $relations)
     * @method _IH_Employee_QB newModelQuery()
     * @method static _IH_Employee_C|Employee[] all()
     * @mixin _IH_Employee_QB
     */
    class Employee extends Model {}
    
    /**
     * @property Employee $employee
     * @method BelongsTo|_IH_Employee_QB employee()
     * @method static _IH_EmployeeContact_QB onWriteConnection()
     * @method _IH_EmployeeContact_QB newQuery()
     * @method static _IH_EmployeeContact_QB on(null|string $connection = null)
     * @method static _IH_EmployeeContact_QB query()
     * @method static _IH_EmployeeContact_QB with(array|string $relations)
     * @method _IH_EmployeeContact_QB newModelQuery()
     * @method static _IH_EmployeeContact_C|EmployeeContact[] all()
     * @mixin _IH_EmployeeContact_QB
     */
    class EmployeeContact extends Model {}
    
    /**
     * @property int|null $area_id
     * @method static _IH_EmployeeContract_QB onWriteConnection()
     * @method _IH_EmployeeContract_QB newQuery()
     * @method static _IH_EmployeeContract_QB on(null|string $connection = null)
     * @method static _IH_EmployeeContract_QB query()
     * @method static _IH_EmployeeContract_QB with(array|string $relations)
     * @method _IH_EmployeeContract_QB newModelQuery()
     * @method static _IH_EmployeeContract_C|EmployeeContract[] all()
     * @mixin _IH_EmployeeContract_QB
     */
    class EmployeeContract extends Model {}
    
    /**
     * @method static _IH_EmployeeEducation_QB onWriteConnection()
     * @method _IH_EmployeeEducation_QB newQuery()
     * @method static _IH_EmployeeEducation_QB on(null|string $connection = null)
     * @method static _IH_EmployeeEducation_QB query()
     * @method static _IH_EmployeeEducation_QB with(array|string $relations)
     * @method _IH_EmployeeEducation_QB newModelQuery()
     * @method static _IH_EmployeeEducation_C|EmployeeEducation[] all()
     * @mixin _IH_EmployeeEducation_QB
     */
    class EmployeeEducation extends Model {}
    
    /**
     * @method static _IH_EmployeeFamily_QB onWriteConnection()
     * @method _IH_EmployeeFamily_QB newQuery()
     * @method static _IH_EmployeeFamily_QB on(null|string $connection = null)
     * @method static _IH_EmployeeFamily_QB query()
     * @method static _IH_EmployeeFamily_QB with(array|string $relations)
     * @method _IH_EmployeeFamily_QB newModelQuery()
     * @method static _IH_EmployeeFamily_C|EmployeeFamily[] all()
     * @mixin _IH_EmployeeFamily_QB
     */
    class EmployeeFamily extends Model {}
    
    /**
     * @property int|null $payroll_id
     * @method static _IH_EmployeePayroll_QB onWriteConnection()
     * @method _IH_EmployeePayroll_QB newQuery()
     * @method static _IH_EmployeePayroll_QB on(null|string $connection = null)
     * @method static _IH_EmployeePayroll_QB query()
     * @method static _IH_EmployeePayroll_QB with(array|string $relations)
     * @method _IH_EmployeePayroll_QB newModelQuery()
     * @method static _IH_EmployeePayroll_C|EmployeePayroll[] all()
     * @mixin _IH_EmployeePayroll_QB
     */
    class EmployeePayroll extends Model {}
    
    /**
     * @method static _IH_EmployeeTermination_QB onWriteConnection()
     * @method _IH_EmployeeTermination_QB newQuery()
     * @method static _IH_EmployeeTermination_QB on(null|string $connection = null)
     * @method static _IH_EmployeeTermination_QB query()
     * @method static _IH_EmployeeTermination_QB with(array|string $relations)
     * @method _IH_EmployeeTermination_QB newModelQuery()
     * @method static _IH_EmployeeTermination_C|EmployeeTermination[] all()
     * @mixin _IH_EmployeeTermination_QB
     */
    class EmployeeTermination extends Model {}
    
    /**
     * @method static _IH_EmployeeWork_QB onWriteConnection()
     * @method _IH_EmployeeWork_QB newQuery()
     * @method static _IH_EmployeeWork_QB on(null|string $connection = null)
     * @method static _IH_EmployeeWork_QB query()
     * @method static _IH_EmployeeWork_QB with(array|string $relations)
     * @method _IH_EmployeeWork_QB newModelQuery()
     * @method static _IH_EmployeeWork_C|EmployeeWork[] all()
     * @mixin _IH_EmployeeWork_QB
     */
    class EmployeeWork extends Model {}
    
    /**
     * @property int $id
     * @property string $name
     * @property int $administration_id
     * @property int $leader_id
     * @property string|null $description
     * @property string $status
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static _IH_MasterPlacement_QB onWriteConnection()
     * @method _IH_MasterPlacement_QB newQuery()
     * @method static _IH_MasterPlacement_QB on(null|string $connection = null)
     * @method static _IH_MasterPlacement_QB query()
     * @method static _IH_MasterPlacement_QB with(array|string $relations)
     * @method _IH_MasterPlacement_QB newModelQuery()
     * @method static _IH_MasterPlacement_C|MasterPlacement[] all()
     * @mixin _IH_MasterPlacement_QB
     */
    class MasterPlacement extends Model {}
}

namespace App\Models\Mobile {

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Carbon;
    use LaravelIdea\Helper\App\Models\Mobile\_IH_MobileActivation_C;
    use LaravelIdea\Helper\App\Models\Mobile\_IH_MobileActivation_QB;
    
    /**
     * @property int $id
     * @property int $user_id
     * @property string $device_id
     * @property string $device_name
     * @property string $status
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static _IH_MobileActivation_QB onWriteConnection()
     * @method _IH_MobileActivation_QB newQuery()
     * @method static _IH_MobileActivation_QB on(null|string $connection = null)
     * @method static _IH_MobileActivation_QB query()
     * @method static _IH_MobileActivation_QB with(array|string $relations)
     * @method _IH_MobileActivation_QB newModelQuery()
     * @method static _IH_MobileActivation_C|MobileActivation[] all()
     * @mixin _IH_MobileActivation_QB
     */
    class MobileActivation extends Model {}
}

namespace App\Models\Payroll {

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Support\Carbon;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_BasicSalary_C;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_BasicSalary_QB;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_PayrollComponent_C;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_PayrollComponent_QB;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_PayrollProcessDetail_C;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_PayrollProcessDetail_QB;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_PayrollProcess_C;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_PayrollProcess_QB;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_PayrollType_C;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_PayrollType_QB;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_PayrollUploadDetail_C;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_PayrollUploadDetail_QB;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_PayrollUpload_C;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_PayrollUpload_QB;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_PositionAllowance_C;
    use LaravelIdea\Helper\App\Models\Payroll\_IH_PositionAllowance_QB;
    
    /**
     * @property int $id
     * @property int $rank_id
     * @property string $value
     * @property string|null $description
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static _IH_BasicSalary_QB onWriteConnection()
     * @method _IH_BasicSalary_QB newQuery()
     * @method static _IH_BasicSalary_QB on(null|string $connection = null)
     * @method static _IH_BasicSalary_QB query()
     * @method static _IH_BasicSalary_QB with(array|string $relations)
     * @method _IH_BasicSalary_QB newModelQuery()
     * @method static _IH_BasicSalary_C|BasicSalary[] all()
     * @mixin _IH_BasicSalary_QB
     */
    class BasicSalary extends Model {}
    
    /**
     * @property int $id
     * @property int $type_id
     * @property string $code
     * @property string $name
     * @property string|null $description
     * @property string $status
     * @property string $type
     * @property string $method
     * @property string $order
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property string|null $method_value
     * @method static _IH_PayrollComponent_QB onWriteConnection()
     * @method _IH_PayrollComponent_QB newQuery()
     * @method static _IH_PayrollComponent_QB on(null|string $connection = null)
     * @method static _IH_PayrollComponent_QB query()
     * @method static _IH_PayrollComponent_QB with(array|string $relations)
     * @method _IH_PayrollComponent_QB newModelQuery()
     * @method static _IH_PayrollComponent_C|PayrollComponent[] all()
     * @mixin _IH_PayrollComponent_QB
     */
    class PayrollComponent extends Model {}
    
    /**
     * @property int $id
     * @property int $location_id
     * @property string $month
     * @property string $year
     * @property string|null $total_employees
     * @property string|null $total_values
     * @property string|null $approved_by
     * @property string $approved_status
     * @property string|null $approved_description
     * @property Carbon|null $approved_date
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property int $type_id
     * @method static _IH_PayrollProcess_QB onWriteConnection()
     * @method _IH_PayrollProcess_QB newQuery()
     * @method static _IH_PayrollProcess_QB on(null|string $connection = null)
     * @method static _IH_PayrollProcess_QB query()
     * @method static _IH_PayrollProcess_QB with(array|string $relations)
     * @method _IH_PayrollProcess_QB newModelQuery()
     * @method static _IH_PayrollProcess_C|PayrollProcess[] all()
     * @mixin _IH_PayrollProcess_QB
     */
    class PayrollProcess extends Model {}
    
    /**
     * @property int $id
     * @property int $process_id
     * @property int $employee_id
     * @property string $value
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property int $component_id
     * @property PayrollComponent $component
     * @method BelongsTo|_IH_PayrollComponent_QB component()
     * @method static _IH_PayrollProcessDetail_QB onWriteConnection()
     * @method _IH_PayrollProcessDetail_QB newQuery()
     * @method static _IH_PayrollProcessDetail_QB on(null|string $connection = null)
     * @method static _IH_PayrollProcessDetail_QB query()
     * @method static _IH_PayrollProcessDetail_QB with(array|string $relations)
     * @method _IH_PayrollProcessDetail_QB newModelQuery()
     * @method static _IH_PayrollProcessDetail_C|PayrollProcessDetail[] all()
     * @mixin _IH_PayrollProcessDetail_QB
     */
    class PayrollProcessDetail extends Model {}
    
    /**
     * @property int $id
     * @property string $code
     * @property string $name
     * @property string|null $description
     * @property string $status
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static _IH_PayrollType_QB onWriteConnection()
     * @method _IH_PayrollType_QB newQuery()
     * @method static _IH_PayrollType_QB on(null|string $connection = null)
     * @method static _IH_PayrollType_QB query()
     * @method static _IH_PayrollType_QB with(array|string $relations)
     * @method _IH_PayrollType_QB newModelQuery()
     * @method static _IH_PayrollType_C|PayrollType[] all()
     * @mixin _IH_PayrollType_QB
     */
    class PayrollType extends Model {}
    
    /**
     * @property int $id
     * @property string $code
     * @property string $month
     * @property string $year
     * @property string|null $total_employees
     * @property string|null $total_values
     * @property string|null $approved_by
     * @property string $approved_status
     * @property string|null $approved_description
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property Carbon|null $approved_date
     * @method static _IH_PayrollUpload_QB onWriteConnection()
     * @method _IH_PayrollUpload_QB newQuery()
     * @method static _IH_PayrollUpload_QB on(null|string $connection = null)
     * @method static _IH_PayrollUpload_QB query()
     * @method static _IH_PayrollUpload_QB with(array|string $relations)
     * @method _IH_PayrollUpload_QB newModelQuery()
     * @method static _IH_PayrollUpload_C|PayrollUpload[] all()
     * @mixin _IH_PayrollUpload_QB
     */
    class PayrollUpload extends Model {}
    
    /**
     * @property int $id
     * @property int $upload_id
     * @property int $employee_id
     * @property string $value
     * @property string|null $description
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static _IH_PayrollUploadDetail_QB onWriteConnection()
     * @method _IH_PayrollUploadDetail_QB newQuery()
     * @method static _IH_PayrollUploadDetail_QB on(null|string $connection = null)
     * @method static _IH_PayrollUploadDetail_QB query()
     * @method static _IH_PayrollUploadDetail_QB with(array|string $relations)
     * @method _IH_PayrollUploadDetail_QB newModelQuery()
     * @method static _IH_PayrollUploadDetail_C|PayrollUploadDetail[] all()
     * @mixin _IH_PayrollUploadDetail_QB
     */
    class PayrollUploadDetail extends Model {}
    
    /**
     * @property int $id
     * @property int $rank_id
     * @property string $value
     * @property string|null $description
     * @property string|null $created_by
     * @property string|null $updated_by
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static _IH_PositionAllowance_QB onWriteConnection()
     * @method _IH_PositionAllowance_QB newQuery()
     * @method static _IH_PositionAllowance_QB on(null|string $connection = null)
     * @method static _IH_PositionAllowance_QB query()
     * @method static _IH_PositionAllowance_QB with(array|string $relations)
     * @method _IH_PositionAllowance_QB newModelQuery()
     * @method static _IH_PositionAllowance_C|PositionAllowance[] all()
     * @mixin _IH_PositionAllowance_QB
     */
    class PositionAllowance extends Model {}
}

namespace App\Models\Recruitment {

    use Illuminate\Database\Eloquent\Model;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentApplicantContact_C;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentApplicantContact_QB;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentApplicantEducation_C;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentApplicantEducation_QB;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentApplicantFamily_C;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentApplicantFamily_QB;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentApplicantWork_C;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentApplicantWork_QB;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentApplicant_C;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentApplicant_QB;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentContract_C;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentContract_QB;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentPlacement_C;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentPlacement_QB;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentPlan_C;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentPlan_QB;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentSelection_C;
    use LaravelIdea\Helper\App\Models\Recruitment\_IH_RecruitmentSelection_QB;
    
    /**
     * @method static _IH_RecruitmentApplicant_QB onWriteConnection()
     * @method _IH_RecruitmentApplicant_QB newQuery()
     * @method static _IH_RecruitmentApplicant_QB on(null|string $connection = null)
     * @method static _IH_RecruitmentApplicant_QB query()
     * @method static _IH_RecruitmentApplicant_QB with(array|string $relations)
     * @method _IH_RecruitmentApplicant_QB newModelQuery()
     * @method static _IH_RecruitmentApplicant_C|RecruitmentApplicant[] all()
     * @mixin _IH_RecruitmentApplicant_QB
     */
    class RecruitmentApplicant extends Model {}
    
    /**
     * @method static _IH_RecruitmentApplicantContact_QB onWriteConnection()
     * @method _IH_RecruitmentApplicantContact_QB newQuery()
     * @method static _IH_RecruitmentApplicantContact_QB on(null|string $connection = null)
     * @method static _IH_RecruitmentApplicantContact_QB query()
     * @method static _IH_RecruitmentApplicantContact_QB with(array|string $relations)
     * @method _IH_RecruitmentApplicantContact_QB newModelQuery()
     * @method static _IH_RecruitmentApplicantContact_C|RecruitmentApplicantContact[] all()
     * @mixin _IH_RecruitmentApplicantContact_QB
     */
    class RecruitmentApplicantContact extends Model {}
    
    /**
     * @method static _IH_RecruitmentApplicantEducation_QB onWriteConnection()
     * @method _IH_RecruitmentApplicantEducation_QB newQuery()
     * @method static _IH_RecruitmentApplicantEducation_QB on(null|string $connection = null)
     * @method static _IH_RecruitmentApplicantEducation_QB query()
     * @method static _IH_RecruitmentApplicantEducation_QB with(array|string $relations)
     * @method _IH_RecruitmentApplicantEducation_QB newModelQuery()
     * @method static _IH_RecruitmentApplicantEducation_C|RecruitmentApplicantEducation[] all()
     * @mixin _IH_RecruitmentApplicantEducation_QB
     */
    class RecruitmentApplicantEducation extends Model {}
    
    /**
     * @method static _IH_RecruitmentApplicantFamily_QB onWriteConnection()
     * @method _IH_RecruitmentApplicantFamily_QB newQuery()
     * @method static _IH_RecruitmentApplicantFamily_QB on(null|string $connection = null)
     * @method static _IH_RecruitmentApplicantFamily_QB query()
     * @method static _IH_RecruitmentApplicantFamily_QB with(array|string $relations)
     * @method _IH_RecruitmentApplicantFamily_QB newModelQuery()
     * @method static _IH_RecruitmentApplicantFamily_C|RecruitmentApplicantFamily[] all()
     * @mixin _IH_RecruitmentApplicantFamily_QB
     */
    class RecruitmentApplicantFamily extends Model {}
    
    /**
     * @method static _IH_RecruitmentApplicantWork_QB onWriteConnection()
     * @method _IH_RecruitmentApplicantWork_QB newQuery()
     * @method static _IH_RecruitmentApplicantWork_QB on(null|string $connection = null)
     * @method static _IH_RecruitmentApplicantWork_QB query()
     * @method static _IH_RecruitmentApplicantWork_QB with(array|string $relations)
     * @method _IH_RecruitmentApplicantWork_QB newModelQuery()
     * @method static _IH_RecruitmentApplicantWork_C|RecruitmentApplicantWork[] all()
     * @mixin _IH_RecruitmentApplicantWork_QB
     */
    class RecruitmentApplicantWork extends Model {}
    
    /**
     * @method static _IH_RecruitmentContract_QB onWriteConnection()
     * @method _IH_RecruitmentContract_QB newQuery()
     * @method static _IH_RecruitmentContract_QB on(null|string $connection = null)
     * @method static _IH_RecruitmentContract_QB query()
     * @method static _IH_RecruitmentContract_QB with(array|string $relations)
     * @method _IH_RecruitmentContract_QB newModelQuery()
     * @method static _IH_RecruitmentContract_C|RecruitmentContract[] all()
     * @mixin _IH_RecruitmentContract_QB
     */
    class RecruitmentContract extends Model {}
    
    /**
     * @method static _IH_RecruitmentPlacement_QB onWriteConnection()
     * @method _IH_RecruitmentPlacement_QB newQuery()
     * @method static _IH_RecruitmentPlacement_QB on(null|string $connection = null)
     * @method static _IH_RecruitmentPlacement_QB query()
     * @method static _IH_RecruitmentPlacement_QB with(array|string $relations)
     * @method _IH_RecruitmentPlacement_QB newModelQuery()
     * @method static _IH_RecruitmentPlacement_C|RecruitmentPlacement[] all()
     * @mixin _IH_RecruitmentPlacement_QB
     */
    class RecruitmentPlacement extends Model {}
    
    /**
     * @method static _IH_RecruitmentPlan_QB onWriteConnection()
     * @method _IH_RecruitmentPlan_QB newQuery()
     * @method static _IH_RecruitmentPlan_QB on(null|string $connection = null)
     * @method static _IH_RecruitmentPlan_QB query()
     * @method static _IH_RecruitmentPlan_QB with(array|string $relations)
     * @method _IH_RecruitmentPlan_QB newModelQuery()
     * @method static _IH_RecruitmentPlan_C|RecruitmentPlan[] all()
     * @mixin _IH_RecruitmentPlan_QB
     */
    class RecruitmentPlan extends Model {}
    
    /**
     * @method static _IH_RecruitmentSelection_QB onWriteConnection()
     * @method _IH_RecruitmentSelection_QB newQuery()
     * @method static _IH_RecruitmentSelection_QB on(null|string $connection = null)
     * @method static _IH_RecruitmentSelection_QB query()
     * @method static _IH_RecruitmentSelection_QB with(array|string $relations)
     * @method _IH_RecruitmentSelection_QB newModelQuery()
     * @method static _IH_RecruitmentSelection_C|RecruitmentSelection[] all()
     * @mixin _IH_RecruitmentSelection_QB
     */
    class RecruitmentSelection extends Model {}
}

namespace App\Models\Setting {

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Illuminate\Database\Eloquent\Relations\MorphToMany;
    use Illuminate\Notifications\DatabaseNotification;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Category_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Category_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_GroupModul_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_GroupModul_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Group_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Group_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Master_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Master_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_MenuAccess_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_MenuAccess_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Menu_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Menu_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Modul_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Modul_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Parameter_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_Parameter_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_SubModul_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_SubModul_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_UserAccess_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_UserAccess_QB;
    use LaravelIdea\Helper\App\Models\Setting\_IH_User_C;
    use LaravelIdea\Helper\App\Models\Setting\_IH_User_QB;
    use LaravelIdea\Helper\Illuminate\Notifications\_IH_DatabaseNotification_C;
    use LaravelIdea\Helper\Illuminate\Notifications\_IH_DatabaseNotification_QB;
    
    /**
     * @property Category $parent
     * @method BelongsTo|_IH_Category_QB parent()
     * @method static _IH_Category_QB onWriteConnection()
     * @method _IH_Category_QB newQuery()
     * @method static _IH_Category_QB on(null|string $connection = null)
     * @method static _IH_Category_QB query()
     * @method static _IH_Category_QB with(array|string $relations)
     * @method _IH_Category_QB newModelQuery()
     * @method static _IH_Category_C|Category[] all()
     * @mixin _IH_Category_QB
     */
    class Category extends Model {}
    
    /**
     * @method static _IH_Group_QB onWriteConnection()
     * @method _IH_Group_QB newQuery()
     * @method static _IH_Group_QB on(null|string $connection = null)
     * @method static _IH_Group_QB query()
     * @method static _IH_Group_QB with(array|string $relations)
     * @method _IH_Group_QB newModelQuery()
     * @method static _IH_Group_C|Group[] all()
     * @mixin _IH_Group_QB
     */
    class Group extends Model {}
    
    /**
     * @method static _IH_GroupModul_QB onWriteConnection()
     * @method _IH_GroupModul_QB newQuery()
     * @method static _IH_GroupModul_QB on(null|string $connection = null)
     * @method static _IH_GroupModul_QB query()
     * @method static _IH_GroupModul_QB with(array|string $relations)
     * @method _IH_GroupModul_QB newModelQuery()
     * @method static _IH_GroupModul_C|GroupModul[] all()
     * @mixin _IH_GroupModul_QB
     */
    class GroupModul extends Model {}
    
    /**
     * @property string|null $parameter
     * @property string|null $additional_parameter
     * @method static _IH_Master_QB onWriteConnection()
     * @method _IH_Master_QB newQuery()
     * @method static _IH_Master_QB on(null|string $connection = null)
     * @method static _IH_Master_QB query()
     * @method static _IH_Master_QB with(array|string $relations)
     * @method _IH_Master_QB newModelQuery()
     * @method static _IH_Master_C|Master[] all()
     * @mixin _IH_Master_QB
     */
    class Master extends Model {}
    
    /**
     * @property _IH_Menu_C|Menu[] $menu
     * @property-read int $menu_count
     * @method HasMany|_IH_Menu_QB menu()
     * @property _IH_MenuAccess_C|MenuAccess[] $menuAccess
     * @property-read int $menu_access_count
     * @method HasMany|_IH_MenuAccess_QB menuAccess()
     * @property Modul $modul
     * @method BelongsTo|_IH_Modul_QB modul()
     * @method static _IH_Menu_QB onWriteConnection()
     * @method _IH_Menu_QB newQuery()
     * @method static _IH_Menu_QB on(null|string $connection = null)
     * @method static _IH_Menu_QB query()
     * @method static _IH_Menu_QB with(array|string $relations)
     * @method _IH_Menu_QB newModelQuery()
     * @method static _IH_Menu_C|Menu[] all()
     * @mixin _IH_Menu_QB
     */
    class Menu extends Model {}
    
    /**
     * @property Menu $menu
     * @method BelongsTo|_IH_Menu_QB menu()
     * @method static _IH_MenuAccess_QB onWriteConnection()
     * @method _IH_MenuAccess_QB newQuery()
     * @method static _IH_MenuAccess_QB on(null|string $connection = null)
     * @method static _IH_MenuAccess_QB query()
     * @method static _IH_MenuAccess_QB with(array|string $relations)
     * @method _IH_MenuAccess_QB newModelQuery()
     * @method static _IH_MenuAccess_C|MenuAccess[] all()
     * @mixin _IH_MenuAccess_QB
     */
    class MenuAccess extends Model {}
    
    /**
     * @property _IH_Menu_C|Menu[] $menu
     * @property-read int $menu_count
     * @method HasMany|_IH_Menu_QB menu()
     * @property _IH_SubModul_C|SubModul[] $submodul
     * @property-read int $submodul_count
     * @method HasMany|_IH_SubModul_QB submodul()
     * @method static _IH_Modul_QB onWriteConnection()
     * @method _IH_Modul_QB newQuery()
     * @method static _IH_Modul_QB on(null|string $connection = null)
     * @method static _IH_Modul_QB query()
     * @method static _IH_Modul_QB with(array|string $relations)
     * @method _IH_Modul_QB newModelQuery()
     * @method static _IH_Modul_C|Modul[] all()
     * @mixin _IH_Modul_QB
     */
    class Modul extends Model {}
    
    /**
     * @method static _IH_Parameter_QB onWriteConnection()
     * @method _IH_Parameter_QB newQuery()
     * @method static _IH_Parameter_QB on(null|string $connection = null)
     * @method static _IH_Parameter_QB query()
     * @method static _IH_Parameter_QB with(array|string $relations)
     * @method _IH_Parameter_QB newModelQuery()
     * @method static _IH_Parameter_C|Parameter[] all()
     * @mixin _IH_Parameter_QB
     */
    class Parameter extends Model {}
    
    /**
     * @property _IH_Menu_C|Menu[] $menu
     * @property-read int $menu_count
     * @method HasMany|_IH_Menu_QB menu()
     * @property Modul $modul
     * @method BelongsTo|_IH_Modul_QB modul()
     * @method static _IH_SubModul_QB onWriteConnection()
     * @method _IH_SubModul_QB newQuery()
     * @method static _IH_SubModul_QB on(null|string $connection = null)
     * @method static _IH_SubModul_QB query()
     * @method static _IH_SubModul_QB with(array|string $relations)
     * @method _IH_SubModul_QB newModelQuery()
     * @method static _IH_SubModul_C|SubModul[] all()
     * @mixin _IH_SubModul_QB
     */
    class SubModul extends Model {}
    
    /**
     * @property Group $group
     * @method BelongsTo|_IH_Group_QB group()
     * @property _IH_DatabaseNotification_C|DatabaseNotification[] $notifications
     * @property-read int $notifications_count
     * @method MorphToMany|_IH_DatabaseNotification_QB notifications()
     * @method static _IH_User_QB onWriteConnection()
     * @method _IH_User_QB newQuery()
     * @method static _IH_User_QB on(null|string $connection = null)
     * @method static _IH_User_QB query()
     * @method static _IH_User_QB with(array|string $relations)
     * @method _IH_User_QB newModelQuery()
     * @method static _IH_User_C|User[] all()
     * @mixin _IH_User_QB
     */
    class User extends Model {}
    
    /**
     * @property Menu $menu
     * @method BelongsTo|_IH_Menu_QB menu()
     * @method static _IH_UserAccess_QB onWriteConnection()
     * @method _IH_UserAccess_QB newQuery()
     * @method static _IH_UserAccess_QB on(null|string $connection = null)
     * @method static _IH_UserAccess_QB query()
     * @method static _IH_UserAccess_QB with(array|string $relations)
     * @method _IH_UserAccess_QB newModelQuery()
     * @method static _IH_UserAccess_C|UserAccess[] all()
     * @mixin _IH_UserAccess_QB
     */
    class UserAccess extends Model {}
}

namespace Glhd\LaravelDumper\Tests {

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use LaravelIdea\Helper\Glhd\LaravelDumper\Tests\_IH_Company_C;
    use LaravelIdea\Helper\Glhd\LaravelDumper\Tests\_IH_Company_QB;
    use LaravelIdea\Helper\Glhd\LaravelDumper\Tests\_IH_User_C;
    use LaravelIdea\Helper\Glhd\LaravelDumper\Tests\_IH_User_QB;
    
    /**
     * @property _IH_User_C|User[] $users
     * @property-read int $users_count
     * @method HasMany|_IH_User_QB users()
     * @method static _IH_Company_QB onWriteConnection()
     * @method _IH_Company_QB newQuery()
     * @method static _IH_Company_QB on(null|string $connection = null)
     * @method static _IH_Company_QB query()
     * @method static _IH_Company_QB with(array|string $relations)
     * @method _IH_Company_QB newModelQuery()
     * @method static _IH_Company_C|Company[] all()
     * @mixin _IH_Company_QB
     */
    class Company extends Model {}
    
    /**
     * @property Company $company
     * @method BelongsTo|_IH_Company_QB company()
     * @method static _IH_User_QB onWriteConnection()
     * @method _IH_User_QB newQuery()
     * @method static _IH_User_QB on(null|string $connection = null)
     * @method static _IH_User_QB query()
     * @method static _IH_User_QB with(array|string $relations)
     * @method _IH_User_QB newModelQuery()
     * @method static _IH_User_C|User[] all()
     * @mixin _IH_User_QB
     */
    class User extends Model {}
}

namespace Illuminate\Notifications {

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\MorphTo;
    use LaravelIdea\Helper\Illuminate\Notifications\_IH_DatabaseNotification_C;
    use LaravelIdea\Helper\Illuminate\Notifications\_IH_DatabaseNotification_QB;
    
    /**
     * @property Model $notifiable
     * @method MorphTo notifiable()
     * @method static _IH_DatabaseNotification_QB onWriteConnection()
     * @method _IH_DatabaseNotification_QB newQuery()
     * @method static _IH_DatabaseNotification_QB on(null|string $connection = null)
     * @method static _IH_DatabaseNotification_QB query()
     * @method static _IH_DatabaseNotification_QB with(array|string $relations)
     * @method _IH_DatabaseNotification_QB newModelQuery()
     * @method static _IH_DatabaseNotification_C|DatabaseNotification[] all()
     * @mixin _IH_DatabaseNotification_QB
     */
    class DatabaseNotification extends Model {}
}

namespace Laravel\Passport {

    use App\Models\Setting\User;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Laravel\Passport\Database\Factories\ClientFactory;
    use LaravelIdea\Helper\App\Models\Setting\_IH_User_QB;
    use LaravelIdea\Helper\Laravel\Passport\_IH_AuthCode_C;
    use LaravelIdea\Helper\Laravel\Passport\_IH_AuthCode_QB;
    use LaravelIdea\Helper\Laravel\Passport\_IH_Client_C;
    use LaravelIdea\Helper\Laravel\Passport\_IH_Client_QB;
    use LaravelIdea\Helper\Laravel\Passport\_IH_PersonalAccessClient_C;
    use LaravelIdea\Helper\Laravel\Passport\_IH_PersonalAccessClient_QB;
    use LaravelIdea\Helper\Laravel\Passport\_IH_RefreshToken_C;
    use LaravelIdea\Helper\Laravel\Passport\_IH_RefreshToken_QB;
    use LaravelIdea\Helper\Laravel\Passport\_IH_Token_C;
    use LaravelIdea\Helper\Laravel\Passport\_IH_Token_QB;
    
    /**
     * @method static _IH_AuthCode_QB onWriteConnection()
     * @method _IH_AuthCode_QB newQuery()
     * @method static _IH_AuthCode_QB on(null|string $connection = null)
     * @method static _IH_AuthCode_QB query()
     * @method static _IH_AuthCode_QB with(array|string $relations)
     * @method _IH_AuthCode_QB newModelQuery()
     * @method static _IH_AuthCode_C|AuthCode[] all()
     * @mixin _IH_AuthCode_QB
     */
    class AuthCode extends Model {}
    
    /**
     * @property-read null|string $plain_secret
     * @method static _IH_Client_QB onWriteConnection()
     * @method _IH_Client_QB newQuery()
     * @method static _IH_Client_QB on(null|string $connection = null)
     * @method static _IH_Client_QB query()
     * @method static _IH_Client_QB with(array|string $relations)
     * @method _IH_Client_QB newModelQuery()
     * @method static _IH_Client_C|Client[] all()
     * @mixin _IH_Client_QB
     * @method static ClientFactory factory(...$parameters)
     */
    class Client extends Model {}
    
    /**
     * @method static _IH_PersonalAccessClient_QB onWriteConnection()
     * @method _IH_PersonalAccessClient_QB newQuery()
     * @method static _IH_PersonalAccessClient_QB on(null|string $connection = null)
     * @method static _IH_PersonalAccessClient_QB query()
     * @method static _IH_PersonalAccessClient_QB with(array|string $relations)
     * @method _IH_PersonalAccessClient_QB newModelQuery()
     * @method static _IH_PersonalAccessClient_C|PersonalAccessClient[] all()
     * @mixin _IH_PersonalAccessClient_QB
     */
    class PersonalAccessClient extends Model {}
    
    /**
     * @method static _IH_RefreshToken_QB onWriteConnection()
     * @method _IH_RefreshToken_QB newQuery()
     * @method static _IH_RefreshToken_QB on(null|string $connection = null)
     * @method static _IH_RefreshToken_QB query()
     * @method static _IH_RefreshToken_QB with(array|string $relations)
     * @method _IH_RefreshToken_QB newModelQuery()
     * @method static _IH_RefreshToken_C|RefreshToken[] all()
     * @mixin _IH_RefreshToken_QB
     */
    class RefreshToken extends Model {}
    
    /**
     * @property User $user
     * @method BelongsTo|_IH_User_QB user()
     * @method static _IH_Token_QB onWriteConnection()
     * @method _IH_Token_QB newQuery()
     * @method static _IH_Token_QB on(null|string $connection = null)
     * @method static _IH_Token_QB query()
     * @method static _IH_Token_QB with(array|string $relations)
     * @method _IH_Token_QB newModelQuery()
     * @method static _IH_Token_C|Token[] all()
     * @mixin _IH_Token_QB
     */
    class Token extends Model {}
}

namespace Laravel\Sanctum {

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\MorphTo;
    use LaravelIdea\Helper\Laravel\Sanctum\_IH_PersonalAccessToken_C;
    use LaravelIdea\Helper\Laravel\Sanctum\_IH_PersonalAccessToken_QB;
    
    /**
     * @property Model $tokenable
     * @method MorphTo tokenable()
     * @method static _IH_PersonalAccessToken_QB onWriteConnection()
     * @method _IH_PersonalAccessToken_QB newQuery()
     * @method static _IH_PersonalAccessToken_QB on(null|string $connection = null)
     * @method static _IH_PersonalAccessToken_QB query()
     * @method static _IH_PersonalAccessToken_QB with(array|string $relations)
     * @method _IH_PersonalAccessToken_QB newModelQuery()
     * @method static _IH_PersonalAccessToken_C|PersonalAccessToken[] all()
     * @mixin _IH_PersonalAccessToken_QB
     */
    class PersonalAccessToken extends Model {}
}