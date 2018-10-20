<?php
/**
 * System messages translation for CodeIgniter(tm)
 *
 * @author	CodeIgniter community
 * @copyright	Copyright (c) 2014-2018, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['signInFail']			= 'Username หรือ Password ผิดกรุณาลองใหม่อีกครั้ง';

// Module
$lang['moduleDashboardDashboard']   = 'แดชบอร์ด';
$lang['moduleSystemAccount']        = 'บัญชีผู้ใช้งาน';
$lang['moduleSystemPermission']     = 'สิทธิ์การเข้าถึง';
$lang['moduleSystemSetting']        = 'ตั้งค่า';
$lang['moduleFanshineCustomer']     = 'ลูกค้าแฟรนไชน์';
$lang['moduleFanshineCommission']   = 'คอมมิสชัน';
$lang['moduleWherehouseLocation']   = 'สถานที่เก็บสินค้า';
$lang['moduleWherehouseProduct']    = 'สินค้า';
$lang['moduleWherehouseStock']      = 'คลังสินค้า';
$lang['moduleAccountProduct']       = 'สินค้านำขาย';
$lang['moduleAccountOrder']         = 'รายการสั่งซื้อ';
$lang['moduleAccountHistory']       = 'ประวัติการสั่งซื้อ';
$lang['moduleAccountExpense']       = 'รายรับ-รายจ่าย';
$lang['moduleReportBenefit']        = 'ผลกำไร';
$lang['moduleReportGrowth']         = 'การเติมโต';

// General
$lang["generalSave"]                = "บันทึก";
$lang["generalUpdate"]              = "เปลี่ยนแปลง";
$lang["generalDelete"]              = "ลบ";
$lang["generalNo"]                  = "ลำดับ";
$lang["generalAction"]              = "ดำเนินการ";
$lang["generalClose"]               = "ปิด";
$lang["generalDeleteConfirm"]       = "คุณแน่ใจหรือไม่ว่าจะลบรายการนี้";
$lang["generalMessage"]             = "ข้อความ";
$lang["generalDate"]                = "วันที่";
$lang["generalNoData"]              = "ไม่มีข้อมูล";

//####################
//Dashboard
//####################
$lang["shippingCount"]              = "สินค้ารอส่ง";
$lang["payCount"]                   = "รายการรอจ่าย";
$lang["newFanshineCount"]           = "แฟรนไชน์ใหม่";
$lang["stockRefilsCount"]           = "สินค้ารอเติม";
$lang["fanshineTree"]               = "แผนผังแฟรนไชน์";
$lang["orderToday"]                 = "รายการสั่งซื้อวันนี้";
$lang["orderAmount"]                = "มูลค่ารวม";
$lang["orderCount"]                 = "จำนวนการสั่งซื้อ";

//###################
// System
//###################

// Account
$lang["systemAccountFirstname"]     = "ชื่อ";
$lang["systemAccountLastname"]      = "นามสกุล";
$lang["systemAccountUsername"]      = "ชื่อบัญชีผู้ใช้";
$lang["systemAccountPassword"]      = "รหัสผ่าน";
$lang["systemAccountModal"]         = "รายละเอียดบัญชีผู้ใช้ใหม่";
$lang["systemAccountNewAccount"]    = "สร้างบัญชีผู้ใช้ใหม่";
$lang["systemAccountCreatedate"]    = "วันที่สร้าง";

// Permission
$lang["systemPermissionFirstname"]  = "ชื่อ";
$lang["systemPermissionLastname"]   = "นามสกุล";
$lang["systemPermissionUsername"]   = "ชื่อบัญชีผู้ใช้";
$lang["systemPermissionPassword"]   = "รหัสผ่าน";
$lang["systemPermissionModal"]      = "รายละเอียดสิทธิการใช้งาน";
$lang["systemPermissionCreatedate"] = "วันที่สร้าง";

// Settin
$lang["systemSettingDefaultSetting"]= "การตั้งค่าเริ่มต้น";
$lang["systemSettingMoneyToPoint"]  = "อัตราการแปลงเงินไปสู่คะแนน";
$lang["systemSettingPointToMoney"]  = "อัตราการแปลงคะแนนไปสู่เงิน";
$lang["systemSettingTax"]           = "ภาษี";
$lang["systemSettingMemberFee"]     = "ค่าธรรมเนียมสมาชิก";
$lang["systemSettingSpecialCondition"] = "เงื่อนไขพิเศษ";
$lang["systemSettingPounderWeight"] = "น้ำหนักแป้ง";
$lang["systemSettingCommission"]    = "ค่าคอมมิสชัน";
$lang["systemSettingRefer"]         = "ค่าแนะนำ";
$lang["systemSettingStandardPoint"] = "มาตรฐานคะแนนขั้นต่ำ";
$lang["systemSettingSchedule"]      = "กำหนดการตั้งค่า";
$lang["systemSettingHistory"]       = "ประวัติการตั้งค่า";

//#####################
// Fanshine
//#####################

// Customer
$lang["fanshineCustomerCode"]           = "รหัส";
$lang["fanshineCustomerFullName"]       = "ชื่อเต็ม";
$lang["fanshineCustomerStatus"]         = "สถานะ";
$lang["fanshineCustomerLevel"]          = "ระดับ";
$lang["fanshineCustomerCreadtedate"]    = "วันที่สมัค";
$lang["fanshineCustomerCreateNewFanshine"] = "สร้างแฟรนไชน์ใหม่";
$lang["fanshineCustomerModalTitle"]     = "รายละเอียดแฟรนไชน์";

$lang["fanshineCustomerFanshineName"]   = "ชื่อแฟรนไชน์";
$lang["fanshineCustomerDay"]            = "วัน";
$lang["fanshineCustomerMonth"]          = "เดือน";
$lang["fanshineCustomerYear"]           = "ปี";
$lang["fanshineCustomerCountry"]        = "ประเทศ";
$lang["fanshineCustomerPassportId"]     = "หมายเลขหนังสือเดินทาง";
$lang["fanshineCustomerPersonalId"]     = "หมายเลขประชาชน";
$lang["fanshineCustomerAddress"]        = "ที่อยู่";
$lang["fanshineCustomerProvince"]       = "จังหวัด";
$lang["fanshineCustomerDistrict"]       = "อำเภอ";
$lang["fanshineCustomerPostcode"]       = "รหัสไปรษณี";
$lang["fanshineCustomerPhoneNumber"]    = "หมายเลขโทรศัพท์";
$lang["fanshineCustomerEmail"]          = "อีเมล";
$lang["fanshineCustomerDeliveryAddress"]= "ที่อยู่สำหรับจัดส่ง";
$lang["fanshineCustomerBankAccount"]    = "หมายเลขขัญชี";
$lang["fanshineCustomerBranch"]         = "สาขา";
$lang["fanshineCustomerAccountName"]    = "ชื่อบัญชี";
$lang["fanshineCustomerRefer"]          = "ผู้แนะนำ";
$lang["fanshineCustomerMaritalStatus"]  = "สถานะการแต่งงาน";
$lang["fanshineCustomerChild"]          = "จำนวนบุตร";
$lang["fanshineCustomerDescendantName"] = "ชื่อผู้รับมรดก";
$lang["fanshineCustomerBank"]           = "ธนาคาร";

// Commissoin
$lang["fanshineCustomerCommissionTime"]   = "ระยะเวลาคอมมิสชัน";
$lang["fanshineCustomerCommissionAmount"] = "ยอดรวมคอมมินชัน";
$lang["fanshineCustomerFilterTitle"]      = "ตัวคัดกรอง";
$lang["fanshineCustomerSearchTitle"]      = "ค้นหา";
$lang["fanshineCustomerReport"]           = "รายงาน";

$lang["fanshineCustomerCycleDate"]        = "วันตัดยอด";
$lang["fanshineCustomerCode"]             = "รหัส";
$lang["fanshineCustomerName"]             = "ชื่อเต็ม";
$lang["fanshineCustomerBank"]             = "ธนาคาร";
$lang["fanshineCustomerBankAccount"]      = "บัญชี";
$lang["fanshineCustomerPrivatePoint"]     = "คะแนนส่วนตัว";
$lang["fanshineCustomerCompanyPoint"]     = "คะแนนองค์กร";
$lang["fanshineCustomerAmount"]           = "ยอดรวม";
$lang["fanshineCustomerCommission"]       = "คอมมิสชัน";

//################
// Wherehouse
//################

// Location
$lang["wherehouseLocationNo"]               = "ลำดับ";
$lang["wherehouseLocationName"]             = "ตำแหน่ง";
$lang["wherehouseLocationDescription"]      = "คำอธิบาย";
$lang["wherehouseLocationCreateNewLocation"]= "สร้างตำแหน่งใหม่";
$lang["wherehouseLocationModalTitle"]       = "รายละเอียดตำแหน่ง";

// Product 
$lang["wherehouseProductSKU"]               = "รหัส";
$lang["wherehouseProductName"]              = "ชื่อสิค้า";
$lang["wherehouseProductLocaiton"]          = "ตำแหน่ง";
$lang["wherehouseProductUnit"]              = "หน่วย";
$lang["wherehouseProductMin"]               = "จำนวนขั้นต่ำ";
$lang["wherehouseProductMax"]               = "จำนวนสูงสุด";
$lang["wherehouseProductType"]              = "ประเภท";
$lang["wherehouseProductModalTitle"]        = "รายละเอียดสินค้า";
$lang["wherehouseProductCreateNewProduct"]  = "สร้างสินค้าใหม่";

// Stock
$lang["wherehouseStockRefils"]              = "เติมสินค้า";
$lang["wherehouseStockFilter"]              = "ตัวคัดกรอง";
$lang["wherehouseStockOutOfStock"]          = "สินค้าหมด";
$lang["wherehouseStockOutOfActualStock"]    = "สินค้าบนชั้นหมด";
$lang["wherehouseStockRefilsOfStock"]       = "สินค้ารอเติม";
$lang["wherehouseStockRefilsOfActualStock"] = "สินค้าบนชั้นรอเติม";
$lang["wherehouseStockTabStock"]            = "คลังสินค้า";
$lang["wherehouseStockTabHistory"]          = "ประวัติ";
$lang["wherehouseStockIn"]                  = "นำเข้า";
$lang["wherehouseStockOut"]                 = "นำออก";
$lang["wherehouseStockAction"]              = "กระบวนการ";

$lang["wherehouseStockNo"]                  = "ลำดับ";
$lang["wherehouseStockSKU"]                 = "รหัส";
$lang["wherehouseStockProductName"]         = "ชื่อสินค้า";
$lang["wherehouseStockType"]                = "ประเภท";
$lang["wherehouseStockLocation"]            = "ตำแหน่ง";
$lang["wherehouseStockStock"]               = "ใช้ได้";
$lang["wherehouseStockActualStock"]         = "จำนวนจริง";
$lang["wherehouseStockActionTime"]          = "เวลา";
$lang["wherehouseStockAmount"]              = "จำนวน";
$lang["wherehouseStockCost"]                = "ต้นทุน";
$lang["wherehouseStockTotal"]               = "มูลค่ารวม";
$lang["wherehouseStockStatus"]              = "สถานะ";
$lang["wherehouseStockExpire"]              = "วันหมดอายุ";
$lang["wherehouseStockModalTitle"]          = "รายละเอียดสินค้า";

//################
// Account
//################

//Product
$lang["accountProductNo"]                = "ลำดับ";
$lang["accountProductSKU"]               = "รหัส";
$lang["accountProductProductName"]       = "ชื่อสินค้า";
$lang["accountProductCreateNewProduct"]  = "สร้างสินค้าใหม่";

$lang["accountProductCost"]              = "ต้นทุน";
$lang["accountProductPrice"]             = "ราคา";
$lang["accountProductDiscount"]          = "ส่วนลด";
$lang["accountProductPoint"]             = "คะแนน";
$lang["accountProductModalTitle"]        = "รายละเอียดสินค้า";

//Order & History
$lang["accountOrderDate"]                =   "วันที่";
$lang["accountOrderCode"]                =   "รหัส";
$lang["accountOrderFanshineName"]        =   "ชื่อแฟรนไชน์";
$lang["accountOrderAmount"]              =   "มูลค่า";
$lang["accountOrderStatus"]              =   "สถานะ";
$lang["accountOrderCreateNewOrder"]      =   "สร้างกรายการสั่งซื้อใหม่";

//Expense
$lang["accountExpenseDate"]             =   "วันที่";
$lang["accountExpenseTitle"]            =   "หัวข้อ";
$lang["accountExpenseDetail"]           =   "รายละเอียด";
$lang["accountExpenseType"]             =   "ประเภท";
$lang["accountExpenseAmount"]           =   "ยอดรวม";
$lang["accountExpenseIncome"]           =   "รายรับ";
$lang["accountExpenseOutcome"]          =   "รายจ่าย";
$lang["accountExpenseExpenseToday"]     =   "รายรับ-รายจ่ายวันนี้";
$lang["accountExpenseFilterTitle"]      =   "ตัวคัดกรอง";
$lang["accountExpenseCreateNewExpense"] =   "สร้างรายการายรับใหม่";

//################
// Report
//################

// Benefit
$lang["reportBenefitCostByProduct"]      =   "ตุ้นทุนจากสินค้า";
$lang["reportBenefitCostByExpense"]      =   "ต้นทุนจากรายการรายจ่าย";
$lang["reportBenefitIncludeWaiting"]     =   "รวมรายการรอจ่าย";
$lang["reportBenefitExpense"]            =   "รายจ่าย";
$lang["reportBenefitIncome"]             =   "รายรับ";
$lang["reportBenefitProfit"]             =   "กำไร";
$lang["reportBenefitProcess"]            =   "ประมวลผล";
$lang["reportBenefitFilterTitle"]        =   "ตัวเลือก";

// Benefit
$lang["reportGrowthCode"]               =   "รหัส";
$lang["reportGrowthFanshineName"]       =   "ชื่อแฟรนไชน์";
$lang["reportGrowthAVG"]                =   "ค่าเฉลี่ย";