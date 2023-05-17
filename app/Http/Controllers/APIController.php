<?php

namespace App\Http\Controllers;

class APIController extends Controller
{
    /**
     *  @SWG\Post(
     *     path="/api/v1/customer/login",
     *     tags={"Authentication"},
     *     summary="Get a JWT via given credentials",
     *     description="Returns a JWT token",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="student_id",
     *         in="formData",
     *         description="Email address",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         description="Password",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Header(
     *             header="Authorization",
     *             description="Bearer {token}",
     *             type="string"
     *         ),
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="error",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 @SWG\Property(
     *                     property="access_token",
     *                     type="string",
     *                     example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly9sb2NhbGhvc3QvYXBpL2xvZ2luIiwiaWF0IjoxNjIwNjIxNjA4LCJleHAiOjE2MjA2Mjc2MDgsIm5iZiI6MTYyMDYyMTYwOCwianRpIjoiTzRVMTM4Q2Fpd1JjM2lxbSJ9.SD_iJmpMSjcnhldl-SP_Gb0Lv9pTde0J32A-JfKzZoU"
     *                 ),
     *                 @SWG\Property(
     *                     property="token_type",
     *                     type="string",
     *                     example="bearer"
     *                 ),
     *                 @SWG\Property(
     *                     property="expires_in",
     *                     type="integer",
     *                     example=3600
     *                 )
     *             )
     *         )
     *     ),
     *      @SWG\Response(
     *         response=400,
     *         description="Invalid request data",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="error",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @SWG\Property(
     *                 property="message",
     *                 type="object",
     *                 example={"email": {"The email field is required."}}
     *             ),
     *             @SWG\Property(
     *                 property="type",
     *                 type="integer",
     *                 example=400
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized"        
     *      )
     *  ),
     * 
     * @SWG\Post(
     *      path="/api/v1/customer/register",
     *      tags={"Authentication"},
     *      summary="Register a new customer",
     *      produces={"application/json"},
     *      consumes={"application/json"},
     *      @SWG\Parameter(
     *          name="name",
     *          in="formData",
     *          description="Name of the customer",
     *          required=true,
     *          type="string"
     *      ),
     *      @SWG\Parameter(
     *          name="email",
     *          in="formData",
     *          description="Email of the customer",
     *          required=true,
     *          type="string"
     *      ),
     *      @SWG\Parameter(
     *          name="password",
     *          in="formData",
     *          description="Password of the customer",
     *          required=true,
     *          type="string"
     *      ),
     *      @SWG\Parameter(
     *          name="password_confirmation",
     *          in="formData",
     *          description="Confirm password of the customer",
     *          required=true,
     *          type="string"
     *      ),
     *      @SWG\Response(
     *          response=201,
     *          description="Customer registered successfully",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="customer",
     *                  ref="#/definitions/Customer"
     *              ),
     *              @SWG\Property(
     *                  property="token",
     *                  type="string",
     *                  description="The JWT token for the authenticated user"
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=422,
     *          description="Validation error",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="error",
     *                  type="boolean",
     *                  example=true
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="object",
     *                  description="Validation error messages"
     *              ),
     *              @SWG\Property(
     *                  property="type",
     *                  type="integer",
     *                  description="Error type code"
     *              )
     *          )
     *      )
     * ),
     * 
     *  @SWG\Post(
     *     path="/api/v1/customer/attendance",
     *     tags={"Feature"},
     *     security = { { "bearerAuth": {} } },
     *     summary="Get a JWT via given credentials",
     *     description="Returns a JWT token",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         description="Email address",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         description="Password",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation",
     *         @SWG\Header(
     *             header="Authorization",
     *             description="Bearer {token}",
     *             type="string"
     *         ),
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="error",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 @SWG\Property(
     *                     property="access_token",
     *                     type="string",
     *                     example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly9sb2NhbGhvc3QvYXBpL2xvZ2luIiwiaWF0IjoxNjIwNjIxNjA4LCJleHAiOjE2MjA2Mjc2MDgsIm5iZiI6MTYyMDYyMTYwOCwianRpIjoiTzRVMTM4Q2Fpd1JjM2lxbSJ9.SD_iJmpMSjcnhldl-SP_Gb0Lv9pTde0J32A-JfKzZoU"
     *                 ),
     *                 @SWG\Property(
     *                     property="token_type",
     *                     type="string",
     *                     example="bearer"
     *                 ),
     *                 @SWG\Property(
     *                     property="expires_in",
     *                     type="integer",
     *                     example=3600
     *                 )
     *             )
     *         )
     *     ),
     *      @SWG\Response(
     *         response=400,
     *         description="Invalid request data",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="error",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @SWG\Property(
     *                 property="message",
     *                 type="object",
     *                 example={"email": {"The email field is required."}}
     *             ),
     *             @SWG\Property(
     *                 property="type",
     *                 type="integer",
     *                 example=400
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized"        
     *      )
     *  ),
     * 
     * @SWG\Definition(
     *      definition="Customer",
     *      type="object",
     *      required={"name", "email"},
     *      @SWG\Property(
     *          property="name",
     *          type="string",
     *          description="Name of the customer"
     *      ),
     *      @SWG\Property(
     *          property="email",
     *          type="string",
     *          description="Email of the customer"
     *      ),
     *      @SWG\Property(
     *          property="phone",
     *          type="string",
     *          description="Phone number of the customer"
     *      )
     * )
     */
