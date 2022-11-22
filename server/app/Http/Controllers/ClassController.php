<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $rawToken = $request->header('Authorization');

        if ($rawToken === null || str_starts_with($rawToken, 'Bearer ') === false) {
            return response()->json([
                'error' => 'No token provided',
            ], 401);
        }

        $token = str_replace('Bearer ', '', $rawToken);
        $page = $request->page ?? 1;
        $number = $request->number ?? 20;
        $teacherId = $request->teacherId ?? null;

        $classEndpoint = 'https://lms-api.mindx.vn/';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $classEndpoint,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '
            {
                "operationName":"GetClasses",
                "variables":{
                    "pageIndex":' . ($page - 1) . ',
                    "itemsPerPage":' . $number . ',
                    "orderBy":"createdAt_desc",
                    "teacherId":"' . $teacherId . '"
                },
                "query":"query GetClasses($search: String, $centre: String, $centres: [String], $courses: [String], $courseLines: [String], $startDateFrom: Date, $startDateTo: Date, $endDateFrom: Date, $endDateTo: Date, $haveSlotFrom: Date, $haveSlotTo: Date, $statusNotEquals: String, $attendanceCheckedExists: Boolean, $status: String, $statusIn: [String], $attendanceStatus: [String], $studentAttendanceStatus: [String], $teacherAttendanceStatus: [String], $pageIndex: Int!, $itemsPerPage: Int!, $orderBy: String, $teacherId: String, $teacherSlot: [String], $passedSessionIndex: Int, $unpassedSessionIndex: Int, $haveSlotIn: HaveSlotIn, $comments: ClassCommentQuery) {\n  classes(payload: {filter_textSearch: $search, centre_equals: $centre, centre_in: $centres, teacher_equals: $teacherId, teacherSlots: $teacherSlot, course_in: $courses, courseLine_in: $courseLines, startDate_gt: $startDateFrom, startDate_lt: $startDateTo, endDate_gt: $endDateFrom, endDate_lt: $endDateTo, haveSlot_from: $haveSlotFrom, haveSlot_to: $haveSlotTo, status_ne: $statusNotEquals, status_in: $statusIn, status_equals: $status, attendanceStatus_in: $attendanceStatus, studentAttendanceStatus_in: $studentAttendanceStatus, teacherAttendanceStatus_in: $teacherAttendanceStatus, attendanceChecked_exists: $attendanceCheckedExists, haveSlot_in: $haveSlotIn, passedSessionIndex: $passedSessionIndex, unpassedSessionIndex: $unpassedSessionIndex, pageIndex: $pageIndex, itemsPerPage: $itemsPerPage, orderBy: $orderBy, comments: $comments}) {\n    data {\n      id\n      name\n      course {\n        id\n        name\n        shortName\n      }\n      startDate\n      endDate\n      status\n      centre {\n        id\n        name\n        shortName\n      }\n      openingRoomNo\n      numberOfSessions\n      numberOfSessionsStatus\n      sessionHour\n      totalHour\n      slots {\n        _id\n        date\n        startTime\n        endTime\n        sessionHour\n        summary\n        homework\n        teachers {\n          _id\n          teacher {\n            id\n            username\n            fullName\n            email\n            phoneNumber\n            user\n            imageUrl\n          }\n          role {\n            id\n            name\n            shortName\n          }\n          isActive\n        }\n        teacherAttendance {\n          _id\n          teacher {\n            id\n            username\n            fullName\n            email\n            phoneNumber\n            user\n            imageUrl\n          }\n          status\n          note\n          createdBy\n          createdAt\n          lastModifiedBy\n          lastModifiedAt\n        }\n        studentAttendance {\n          _id\n          student {\n            id\n            fullName\n            phoneNumber\n            email\n            gender\n            imageUrl\n          }\n          status\n          comment\n          sendCommentStatus\n        }\n      }\n      students {\n        _id\n        student {\n          id\n          customer {\n            fullName\n            phoneNumber\n            email\n            facebook\n            zalo\n          }\n        }\n        note\n        activeInClass\n        createdBy\n        createdAt\n      }\n      teachers {\n        _id\n        teacher {\n          id\n          username\n          fullName\n          imageUrl\n          email\n          phoneNumber\n        }\n        role {\n          id\n          name\n          shortName\n          description\n          isActive\n        }\n        isActive\n      }\n      operator {\n        id\n        username\n        firstName\n        middleName\n        lastName\n      }\n      hasSchedule\n      createdBy\n      createdAt\n      lastModifiedBy\n      lastModifiedAt\n    }\n    pagination {\n      type\n      total\n    }\n  }\n}\n"
             }
            ',
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $token,
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }

        curl_close($curl);

        if (isset($error_msg)) {
            return response()->json([
                'error' => $error_msg,
            ], 400);
        }

        return response()->json(json_decode($response));
    }

    public function getClassesWithoutTeacherId(Request $request)
    {
        $rawToken = $request->header('Authorization');

        if ($rawToken === null || str_starts_with($rawToken, 'Bearer ') === false) {
            return response()->json([
                'error' => 'No token provided',
            ], 401);
        }

        $token = str_replace('Bearer ', '', $rawToken);
        $page = $request->page ?? 1;
        $number = $request->number ?? 20;

        $classEndpoint = 'https://lms-api.mindx.vn/';

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $classEndpoint,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '
                {
                    "operationName":"GetClasses",
                    "variables":{
                        "search":"",
                        "centres":[
                            
                        ],
                        "courses":[
                            
                        ],
                        "courseLines":[
                            
                        ],
                        "startDate":[
                            null,
                            null
                        ],
                        "endDate":[
                            null,
                            null
                        ],
                        "pageIndex":' . $page . ',
                        "itemsPerPage":' . $number . ',
                        "orderBy":"createdAt_desc",
                        "type":"OFFSET",
                        "teacherSlot":[
                            
                        ],
                        "passedSessionIndex":null,
                        "unpassedSessionIndex":null,
                        "haveSlotIn":{
                            
                        },
                        "comments":{
                            "criteria":[
                                
                            ]
                        }
                    },
                    "query":"query GetClasses($search: String, $centre: String, $centres: [String], $courses: [String], $courseLines: [String], $startDateFrom: Date, $startDateTo: Date, $endDateFrom: Date, $endDateTo: Date, $haveSlotFrom: Date, $haveSlotTo: Date, $statusNotEquals: String, $attendanceCheckedExists: Boolean, $status: String, $statusIn: [String], $attendanceStatus: [String], $studentAttendanceStatus: [String], $teacherAttendanceStatus: [String], $pageIndex: Int!, $itemsPerPage: Int!, $orderBy: String, $teacherId: String, $teacherSlot: [String], $passedSessionIndex: Int, $unpassedSessionIndex: Int, $haveSlotIn: HaveSlotIn, $comments: ClassCommentQuery) {\n  classes(payload: {filter_textSearch: $search, centre_equals: $centre, centre_in: $centres, teacher_equals: $teacherId, teacherSlots: $teacherSlot, course_in: $courses, courseLine_in: $courseLines, startDate_gt: $startDateFrom, startDate_lt: $startDateTo, endDate_gt: $endDateFrom, endDate_lt: $endDateTo, haveSlot_from: $haveSlotFrom, haveSlot_to: $haveSlotTo, status_ne: $statusNotEquals, status_in: $statusIn, status_equals: $status, attendanceStatus_in: $attendanceStatus, studentAttendanceStatus_in: $studentAttendanceStatus, teacherAttendanceStatus_in: $teacherAttendanceStatus, attendanceChecked_exists: $attendanceCheckedExists, haveSlot_in: $haveSlotIn, passedSessionIndex: $passedSessionIndex, unpassedSessionIndex: $unpassedSessionIndex, pageIndex: $pageIndex, itemsPerPage: $itemsPerPage, orderBy: $orderBy, comments: $comments}) {\n    data {\n      id\n      name\n      course {\n        id\n        name\n        shortName\n      }\n      startDate\n      endDate\n      status\n      centre {\n        id\n        name\n        shortName\n      }\n      openingRoomNo\n      numberOfSessions\n      numberOfSessionsStatus\n      sessionHour\n      totalHour\n      slots {\n        _id\n        date\n        startTime\n        endTime\n        sessionHour\n        summary\n        homework\n        teachers {\n          _id\n          teacher {\n            id\n            username\n            fullName\n            email\n            phoneNumber\n            user\n            imageUrl\n          }\n          role {\n            id\n            name\n            shortName\n          }\n          isActive\n        }\n        teacherAttendance {\n          _id\n          teacher {\n            id\n            username\n            fullName\n            email\n            phoneNumber\n            user\n            imageUrl\n          }\n          status\n          note\n          createdBy\n          createdAt\n          lastModifiedBy\n          lastModifiedAt\n        }\n        studentAttendance {\n          _id\n          student {\n            id\n            fullName\n            phoneNumber\n            email\n            gender\n            imageUrl\n          }\n          status\n          comment\n          sendCommentStatus\n        }\n      }\n      students {\n        _id\n        student {\n          id\n          customer {\n            fullName\n            phoneNumber\n            email\n            facebook\n            zalo\n          }\n        }\n        note\n        activeInClass\n        createdBy\n        createdAt\n      }\n      teachers {\n        _id\n        teacher {\n          id\n          username\n          fullName\n          imageUrl\n          email\n          phoneNumber\n        }\n        role {\n          id\n          name\n          shortName\n          description\n          isActive\n        }\n        isActive\n      }\n      operator {\n        id\n        username\n        firstName\n        middleName\n        lastName\n      }\n      hasSchedule\n      createdBy\n      createdAt\n      lastModifiedBy\n      lastModifiedAt\n    }\n    pagination {\n      type\n      total\n    }\n  }\n}\n"
                }
            ',
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $token,
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }

        curl_close($curl);

        if (isset($error_msg)) {
            return response()->json([
                'error' => $error_msg,
            ], 400);
        }

        return response()->json(json_decode($response));
    }
}
