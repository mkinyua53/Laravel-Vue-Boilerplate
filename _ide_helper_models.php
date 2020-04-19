<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Assignment
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $date
 * @property \Illuminate\Support\Carbon|null $due_date
 * @property int $classroom_id
 * @property int $subject_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Classroom $classroom
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AssignmentFile[] $files
 * @property-read int|null $files_count
 * @property-read \App\Subject $subject
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AssignmentView[] $views
 * @property-read int|null $views_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Assignment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereClassroomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Assignment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Assignment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Assignment withoutTrashed()
 */
	class Assignment extends \Eloquent {}
}

namespace App{
/**
 * App\AssignmentFile
 *
 * @property int $id
 * @property int $assignment_id
 * @property string|null $file
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Assignment $assignment
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentFile newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\AssignmentFile onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentFile query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentFile whereAssignmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentFile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentFile whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AssignmentFile withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\AssignmentFile withoutTrashed()
 */
	class AssignmentFile extends \Eloquent {}
}

namespace App{
/**
 * App\AssignmentView
 *
 * @property int $id
 * @property int $assignment_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Assignment $assignment
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentView newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentView newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\AssignmentView onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentView query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentView whereAssignmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentView whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentView whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentView whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AssignmentView whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\AssignmentView withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\AssignmentView withoutTrashed()
 */
	class AssignmentView extends \Eloquent {}
}

namespace App{
/**
 * App\Classroom
 *
 * @property int $id
 * @property string|null $name
 * @property int $grade_id
 * @property int $stream_id
 * @property int $term_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Assignment[] $assignments
 * @property-read int|null $assignments_count
 * @property-read \App\Grade $grade
 * @property-read \App\Stream $stream
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Student[] $students
 * @property-read int|null $students_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Subject[] $subjects
 * @property-read int|null $subjects_count
 * @property-read \App\Term $term
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Classroom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Classroom newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Classroom onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Classroom query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Classroom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Classroom whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Classroom whereGradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Classroom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Classroom whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Classroom whereStreamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Classroom whereTermId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Classroom whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Classroom withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Classroom withoutTrashed()
 */
	class Classroom extends \Eloquent {}
}

namespace App{
/**
 * App\Grade
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Classroom[] $classrooms
 * @property-read int|null $classrooms_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Grade onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Grade whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Grade withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Grade withoutTrashed()
 */
	class Grade extends \Eloquent {}
}

namespace App{
/**
 * App\Guardian
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $avatar
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Student[] $students
 * @property-read int|null $students_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Guardian onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Guardian whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Guardian withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Guardian withoutTrashed()
 */
	class Guardian extends \Eloquent {}
}

namespace App{
/**
 * App\Permission
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission query()
 */
	class Permission extends \Eloquent {}
}

namespace App{
/**
 * App\Role
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role query()
 */
	class Role extends \Eloquent {}
}

namespace App{
/**
 * App\Stream
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Classroom[] $classrooms
 * @property-read int|null $classrooms_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stream newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stream newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Stream onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stream query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stream whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stream whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stream whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stream whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Stream whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Stream withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Stream withoutTrashed()
 */
	class Stream extends \Eloquent {}
}

namespace App{
/**
 * App\Student
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $admission_number
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $identification
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Classroom[] $classrooms
 * @property-read int|null $classrooms_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $member
 * @property-read int|null $member_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Student onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereAdmissionNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereIdentification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Student withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Student withoutTrashed()
 */
	class Student extends \Eloquent {}
}

namespace App{
/**
 * App\Subject
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Assignment[] $assignments
 * @property-read int|null $assignments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Classroom[] $classrooms
 * @property-read int|null $classrooms_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subject newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Subject onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subject query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subject whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Subject whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Subject withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Subject withoutTrashed()
 */
	class Subject extends \Eloquent {}
}

namespace App{
/**
 * App\Teacher
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $identification
 * @property string|null $avatar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Assignment[] $assignments
 * @property-read int|null $assignments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $member
 * @property-read int|null $member_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Teacher newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Teacher onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Teacher query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Teacher whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Teacher whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Teacher whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Teacher whereIdentification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Teacher whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Teacher wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Teacher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Teacher withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Teacher withoutTrashed()
 */
	class Teacher extends \Eloquent {}
}

namespace App{
/**
 * App\Term
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $end_date
 * @property string|null $start_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Term[] $classrooms
 * @property-read int|null $classrooms_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Term newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Term newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Term onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Term query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Term whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Term whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Term whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Term whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Term whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Term whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Term whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Term withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Term withoutTrashed()
 */
	class Term extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $phone_number
 * @property string $password
 * @property int|null $memberable_id
 * @property string|null $memberable_type
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $memberable
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMemberableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMemberableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

