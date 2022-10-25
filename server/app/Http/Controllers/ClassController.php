<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $start = microtime(true);
        Log::channel('mindx_requests')->info('----- getClasses request -----');
        Log::channel('mindx_requests')->info('From IP: ' . $request->ip());

        $accessToken = $request->accessToken;

        $response = Cache::remember('classes.index', 5 * 60, function () use ($accessToken) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://lms-api.mindx.vn/',
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                  "operationName": "GetClasses",
                  "variables": {
                    "pageIndex": 0,
                    "itemsPerPage": 20,
                    "orderBy": "createdAt_desc",
                    "teacherId": "62cc21e25b877e1a3bc873cb"
                  },
                  "query": "query GetClasses($search: String, $centre: String, $centres: [String], $courses: [String], $courseLines: [String], $startDateFrom: Date, $startDateTo: Date, $endDateFrom: Date, $endDateTo: Date, $haveSlotFrom: Date, $haveSlotTo: Date, $statusNotEquals: String, $attendanceCheckedExists: Boolean, $status: String, $statusIn: [String], $attendanceStatus: [String], $studentAttendanceStatus: [String], $teacherAttendanceStatus: [String], $pageIndex: Int!, $itemsPerPage: Int!, $orderBy: String, $teacherId: String, $teacherSlot: [String], $passedSessionIndex: Int, $unpassedSessionIndex: Int, $haveSlotIn: HaveSlotIn, $comments: ClassCommentQuery) {\n  classes(payload: {filter_textSearch: $search, centre_equals: $centre, centre_in: $centres, teacher_equals: $teacherId, teacherSlots: $teacherSlot, course_in: $courses, courseLine_in: $courseLines, startDate_gt: $startDateFrom, startDate_lt: $startDateTo, endDate_gt: $endDateFrom, endDate_lt: $endDateTo, haveSlot_from: $haveSlotFrom, haveSlot_to: $haveSlotTo, status_ne: $statusNotEquals, status_in: $statusIn, status_equals: $status, attendanceStatus_in: $attendanceStatus, studentAttendanceStatus_in: $studentAttendanceStatus, teacherAttendanceStatus_in: $teacherAttendanceStatus, attendanceChecked_exists: $attendanceCheckedExists, haveSlot_in: $haveSlotIn, passedSessionIndex: $passedSessionIndex, unpassedSessionIndex: $unpassedSessionIndex, pageIndex: $pageIndex, itemsPerPage: $itemsPerPage, orderBy: $orderBy, comments: $comments}) {\n    data {\n      id\n      name\n      course {\n        id\n        name\n        shortName\n      }\n      startDate\n      endDate\n      status\n      centre {\n        id\n        name\n        shortName\n      }\n      openingRoomNo\n      numberOfSessions\n      numberOfSessionsStatus\n      sessionHour\n      totalHour\n      slots {\n        _id\n        date\n        startTime\n        endTime\n        sessionHour\n        summary\n        homework\n        teachers {\n          _id\n          teacher {\n            id\n            username\n            fullName\n            email\n            phoneNumber\n            user\n            imageUrl\n          }\n          role {\n            id\n            name\n            shortName\n          }\n          isActive\n        }\n        teacherAttendance {\n          _id\n          teacher {\n            id\n            username\n            fullName\n            email\n            phoneNumber\n            user\n            imageUrl\n          }\n          status\n          note\n          createdBy\n          createdAt\n          lastModifiedBy\n          lastModifiedAt\n        }\n        studentAttendance {\n          _id\n          student {\n            id\n            fullName\n            phoneNumber\n            email\n            gender\n            imageUrl\n          }\n          status\n          comment\n          sendCommentStatus\n        }\n      }\n      students {\n        _id\n        student {\n          id\n          customer {\n            fullName\n            phoneNumber\n            email\n            facebook\n            zalo\n          }\n        }\n        note\n        activeInClass\n        createdBy\n        createdAt\n      }\n      teachers {\n        _id\n        teacher {\n          id\n          username\n          fullName\n          imageUrl\n          email\n          phoneNumber\n        }\n        role {\n          id\n          name\n          shortName\n          description\n          isActive\n        }\n        isActive\n      }\n      operator {\n        id\n        username\n        firstName\n        middleName\n        lastName\n      }\n      hasSchedule\n      createdBy\n      createdAt\n      lastModifiedBy\n      lastModifiedAt\n    }\n    pagination {\n      type\n      total\n    }\n  }\n}\n"
                }',
                CURLOPT_HTTPHEADER => [
                    'Authorization: ' . $accessToken,
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

            return $response;
        });

        $time = microtime(true) - $start;
        Log::channel('mindx_requests')->info('Request `GetClasses` to `https://lms-api.mindx.vn/` cost ' . number_format($time, 3) . 's' . "\n");
        Cache::flush();

        return response()->json(json_decode($response, true));
    }

    public function show($id, Request $request)
    {
        $start = microtime(true);
        Log::channel('mindx_requests')->info('----- getClass request -----');
        Log::channel('mindx_requests')->info('From IP: ' . $request->ip());

        $accessToken = $request->accessToken;

        $response = Cache::remember('classes.show.' . $id, 5 * 60, function () use ($id, $accessToken) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://lms-api.mindx.vn/',
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{"operationName":"GetClassById","variables":{"id":"' . $id . '"},"query":"query GetClassById($id: ID!) {\n  classesById(id: $id) {\n    id\n    name\n    course {\n      id\n      name\n      shortName\n      isActive\n      numberOfSession\n      sessionHour\n      description\n      minStudents\n      maxEnrollSession\n      maxStudents\n      optimalStudents\n      oneSessionSettings {\n        _id\n        classRole {\n          id\n          name\n          shortName\n          description\n          isActive\n          createdAt\n          createdBy\n          lastModifiedAt\n          lastModifiedBy\n        }\n        quantity\n      }\n      sessionSettings {\n        _id\n        sessionNumber\n        settings {\n          _id\n          classRole {\n            id\n            name\n            shortName\n            description\n            isActive\n            createdAt\n            createdBy\n            lastModifiedAt\n            lastModifiedBy\n          }\n          quantity\n        }\n      }\n    }\n    startDate\n    endDate\n    status\n    centre {\n      id\n      name\n      shortName\n      hotline\n      email\n      address\n      isActive\n    }\n    histories {\n      action\n      changes {\n        op\n        path\n        from\n        to\n      }\n      createdBy {\n        displayName\n      }\n      createdAt\n    }\n    openingRoomNo\n    numberOfSessions\n    numberOfSessionsStatus\n    sessionHour\n    totalHour\n    slots {\n      _id\n      date\n      startTime\n      endTime\n      sessionHour\n      teachers {\n        _id\n        teacher {\n          id\n          username\n          code\n          fullName\n          email\n          phoneNumber\n          user\n          imageUrl\n        }\n        role {\n          id\n          name\n          shortName\n        }\n        isActive\n      }\n      teacherAttendance {\n        _id\n        teacher {\n          id\n          username\n          fullName\n          email\n          phoneNumber\n          user\n          imageUrl\n        }\n        status\n        note\n        createdBy\n        createdAt\n        lastModifiedBy\n        lastModifiedAt\n      }\n      studentAttendance {\n        _id\n        student {\n          id\n          fullName\n          phoneNumber\n          email\n          gender\n          imageUrl\n          customer {\n            email\n          }\n        }\n        comment\n        sendCommentStatus\n        status\n        commentByAreas {\n          grade\n          content\n          commentAreaId\n        }\n        createdBy\n        createdAt\n        lastModifiedBy\n        lastModifiedAt\n      }\n      summary\n      homework\n      createdAt\n      createdBy\n      lastModifiedAt\n      lastModifiedBy\n    }\n    scheduleSettings {\n      _id\n      date\n      startTime\n      endTime\n      repeated\n    }\n    students {\n      _id\n      student {\n        id\n        fullName\n        phoneNumber\n        email\n        gender\n        dob\n        address\n        imageUrl\n        facebook\n        zalo\n        school\n        customer {\n          fullName\n          phoneNumber\n          email\n          facebook\n          zalo\n        }\n      }\n      note\n      activeInClass\n      createdBy\n      createdAt\n    }\n    teachers {\n      _id\n      teacher {\n        id\n        username\n        fullName\n        imageUrl\n        email\n        phoneNumber\n      }\n      role {\n        id\n        name\n        shortName\n        description\n        isActive\n      }\n      isActive\n    }\n    operator {\n      id\n      email\n      firstName\n      middleName\n      lastName\n      displayName\n      username\n    }\n    contactTeacher {\n      id\n      email\n      phoneNumber\n      fullName\n      code\n      username\n    }\n    hasSchedule\n    links {\n      _id\n      name\n      url\n    }\n    createdBy\n    createdAt\n    lastModifiedBy\n    lastModifiedAt\n  }\n}\n"}',
                CURLOPT_HTTPHEADER => [
                    'Authorization: ' . $accessToken,
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

            return $response;
        });

        $time = microtime(true) - $start;
        Log::channel('mindx_requests')->info('Request `GetClassById` with [id => ' . $id . '] to `https://lms-api.mindx.vn/` cost ' . number_format($time, 3) . 's' . "\n");
        Cache::flush();

        return response()->json(json_decode($response, true));
    }
}