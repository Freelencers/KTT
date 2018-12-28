*** Settings ***
Library            Selenium2Library
Library            BuiltIn
Library            String
Suite Teardown     Close Browser

*** Variable ***
${baseUrl}               http://127.0.0.1:8888
${inputUsernameXpath}    name=accUsername
${inputPasswordXpath}    name=accPassword
${loginButtonXpath}      xpath=(/html/body/div/div[2]/form/div[3]/div[2]/button)
${username}              admin
${password}              admin 
${firstname}             firstname
${lastname}              lastname

*** Keywords ***
Login 
    [Arguments]         ${username}         ${password}
    Go To               ${baseUrl}/index.php/Font-end/Auth/signIn
    Input Text          name=accUsername    ${username}
    Input Text          name=accPassword    ${password}
    Click Element       name=signInButton 
    Location Should Be  ${baseUrl}/index.php/Font-end/Welcome

Clear Data
    Go To               ${baseUrl}/index.php/General/resetData/pakornt
    Wait Until Page Contains    empty

Load Is Done
    Wait Until Element Is Not Visible   class=pace

# Account Module


Create New Account
    [Arguments]         ${firstname}    ${lastname}     ${username}     ${password}
    Go To               ${baseUrl}/index.php/Font-end/System/Account
    Load Is Done
    Click Element       id=createNewAcountButtom
    Wait Until Element Is Visible   id=modal-createNewAccount
    Input Text          id=accFirstname     ${firstname}  
    Input Text          id=accLastname      ${lastname}
    Input Text          id=accUsername      ${username}
    Input Text          id=accPassword      ${password}
    Click Element       id=modalSaveButton
    Wait Until Element Is Visible   xpath=(//*[@id="tbodyAccountList"]/tr/td[text()='${firstname}']/following-sibling::td[2])
    Element Should Be Visible   xpath=(//*[@id="tbodyAccountList"]/tr/td[text()='${firstname}']/following-sibling::td[2])

Change Detail Account
    [Arguments]         ${firstname}    ${lastname}     ${username}     ${password}
    Go To               ${baseUrl}/index.php/Font-end/System/Account
    Load Is Done
    Wait Until Element Is Visible   //*[@id="tbodyAccountList"]/tr[2]/td[6]/i[1]
    Click Element       //*[@id="tbodyAccountList"]/tr[2]/td[6]/i[1]
    Load Is Done
    Input Text          id=accFirstname     ${firstname}  
    Input Text          id=accLastname      ${lastname}
    #Input Text          id=accUsername      ${username}
    Input Text          id=accPassword      ${password}
    Click Element       id=modalSaveButton
    Load Is Done
    Element Should Be Visible  //*[@id="tbodyAccountList"]/tr[2]/td[contains(text(), '${firstname}')]

Delete Account
    Go To               ${baseUrl}/index.php/Font-end/System/Account
    Load Is Done
    Click Element       //*[@id="tbodyAccountList"]/tr[2]/td[6]/i[2]
    Wait Until Element Is Visible   id=deleteButtonConfirm
    Click Element       id=deleteButtonConfirm 
    Load Is Done
    Element Should Not Be Visible    //*[@id="tbodyAccountList"]/tr[2]

Logout
    Go To               ${baseUrl}/index.php/Auth/Access/signOut
    Location Should Be  ${baseUrl}/index.php/Font-end/Auth/signIn

Change Permission And Check Permission
    Go To           ${baseUrl}/index.php/Font-end/System/Permission
    Load Is Done
    Click Element   //*[@id="tbodyAccountList"]/tr[2]/td[6]/i[1]
    Load Is Done
    Wait Until Element Is Visible   id=modal-permissionSetting

    # Check Box
    Select Checkbox    //*[@id="bodyModal"]/div[2]/div/input
    Load Is Done
    Select Checkbox    //*[@id="bodyModal"]/div[4]/div/input
    Load Is Done
    Select Checkbox    //*[@id="bodyModal"]/div[6]/div/input
    Load Is Done
    Select Checkbox    //*[@id="bodyModal"]/div[8]/div/input
    Load Is Done
    Select Checkbox    //*[@id="bodyModal"]/div[10]/div/input
    Load Is Done
    Select Checkbox    //*[@id="bodyModal"]/div[12]/div/input
    Load Is Done

    Logout
    Login   username  passwordChange

    Element Should Be Visible   //*[contains(text(), 'Dashboard')]
    Element Should Be Visible   //*[contains(text(), 'Account')]
    Element Should Be Visible   //*[contains(text(), 'Customer')]
    Element Should Be Visible   //*[contains(text(), 'Location')]
    Element Should Be Visible   //*[contains(text(), 'Product')]
    Element Should Be Visible   //*[contains(text(), 'Benefit')]

Setting Default
    Go To   ${baseUrl}/index.php/Font-end/System/Setting
    Load Is Done
    Input Text  id=moneyToPoint         100     
    Input Text  id=pointToMoneyLevelS   100  
    Input Text  id=tax                  100 
    Input Text  id=pointToMoneyLevelL   100
    Input Text  id=standardPoint        100 
    Input Text  id=sFee                 100 
    Input Text  id=lFee                 200 
    Input Text  id=pounderWeight        100 
    Input Text  id=commission           100 
    Input Text  id=refer                100 
    Click Element   id=saveSettingDefault
    Load Is Done
    Wait Until Element Is Visible   id=modal-success 
    Click Element   //button[contains(text(), 'Done')]

Setting Schedule
    [Arguments]     ${dateStart}    ${dateEnd}
    Go To   ${baseUrl}/index.php/Font-end/System/Setting
    Load Is Done
    Click Element   id=createScheduleButton
    Wait Until Element Is Visible   id=modal-createSchedule
    # Click Element  id=scheduleDateRang
    # Input Text     name=daterangepicker_start   ${dateStart}
    # Input Text     name=daterangepicker_end     ${dateEnd}
    Input Text     id=scheduleDateRang      22/12/2019 - 29/12/2019
    Click Element  //button[contains(@class, 'applyBtn')]
    Wait Until Element Is Not Visible   //button[contains(@class, 'applyBtn')]
    Input Text  //*[@id='moneyToPoint' and contains(@class, 'validateScheduleSettingForm')]            100     
    Input Text  //*[@id='pointToMoneyLevelS' and contains(@class, 'validateScheduleSettingForm')]      100  
    Input Text  //*[@id='tax' and contains(@class, 'validateScheduleSettingForm')]                     100 
    Input Text  //*[@id='pointToMoneyLevelL' and contains(@class, 'validateScheduleSettingForm')]      100
    Input Text  //*[@id='standardPoint' and contains(@class, 'validateScheduleSettingForm')]           100 
    Input Text  //*[@id='sFee' and contains(@class, 'validateScheduleSettingForm')]                    100 
    Input Text  //*[@id='lFee' and contains(@class, 'validateScheduleSettingForm')]                    200 
    Input Text  //*[@id='pounderWeight' and contains(@class, 'validateScheduleSettingForm')]           100 
    Input Text  //*[@id='commission' and contains(@class, 'validateScheduleSettingForm')]              100 
    Input Text  //*[@id='refer' and contains(@class, 'validateScheduleSettingForm')]                   100
    Click Element   id=saveButtonModal
    Load Is Done
    Wait Until Element Is Visible   id=modal-success 
    Click Element   //button[contains(text(), 'Done')]
    Wait Until Element Is Not Visible   //button[contains(text(), 'Done')]
    Load Is Done
    Click Element   //div[@class='nav-tabs-custom']//a[contains(text(), 'Schedule')]
    Wait Until Element Is Visible   //*[@id="tbodyScheduleList"]/tr
    Element Should Be Visible   //*[@id="tbodyScheduleList"]/tr

Change Setting Schedule
    [Arguments]     ${dateStart}    ${dateEnd}
    Go To   ${baseUrl}/index.php/Font-end/System/Setting
    Load Is Done
    Click Element  //*[@id="tbodyScheduleList"]/tr/td[13]/i[1] 
    Load Is Done
    Wait Until Element Is Visible   id=modal-createSchedule
    Input Text     id=scheduleDateRang      01/10/2018 - 01/10/2019
    Click Element  //button[contains(@class, 'applyBtn')]
    Wait Until Element Is Not Visible   //button[contains(@class, 'applyBtn')]
    Input Text  //*[@id='moneyToPoint' and contains(@class, 'validateScheduleSettingForm')]            100     
    Input Text  //*[@id='pointToMoneyLevelS' and contains(@class, 'validateScheduleSettingForm')]      100  
    Input Text  //*[@id='tax' and contains(@class, 'validateScheduleSettingForm')]                     100 
    Input Text  //*[@id='pointToMoneyLevelL' and contains(@class, 'validateScheduleSettingForm')]      100
    Input Text  //*[@id='standardPoint' and contains(@class, 'validateScheduleSettingForm')]           100 
    Input Text  //*[@id='sFee' and contains(@class, 'validateScheduleSettingForm')]                    100 
    Input Text  //*[@id='lFee' and contains(@class, 'validateScheduleSettingForm')]                    300 
    Input Text  //*[@id='pounderWeight' and contains(@class, 'validateScheduleSettingForm')]           100 
    Input Text  //*[@id='commission' and contains(@class, 'validateScheduleSettingForm')]              100 
    Input Text  //*[@id='refer' and contains(@class, 'validateScheduleSettingForm')]                   100
    Click Element   id=saveButtonModal
    Load Is Done
    Wait Until Element Is Visible   id=modal-success 
    Click Element   //button[contains(text(), 'Done')]
    Wait Until Element Is Not Visible   //button[contains(text(), 'Done')]
    Click Element   //div[@class='nav-tabs-custom']//a[contains(text(), 'Schedule')]
    Element Should Be Visible   //*[@id="tbodyScheduleList"]/tr/td[contains(text(), '01/10/2561')]
    Element Should Be Visible   //*[@id="tbodyScheduleList"]/tr/td[contains(text(), '01/10/2562')]

Create New Customer
    [Arguments]     ${fanshineName}     ${referIndex}
    Go To   ${baseUrl}/index.php/Font-end/Fanshine/Customer
    Load Is Done
    Click Element   id=createNewAcountButtom
    Wait Until Element Is Visible   id=modal-createNewAccount
    Input Text  id=cusFanshineName  ${fanshineName} 
    Input Text  id=cusFullName      FullName
    Input Text  id=cusDateOfBirth   12/09/1994
    Select From List By Index   //select[@id='cusLevel']    0
    Select From List By Index   //select[@id='cusCouId']    0
    Input Text  id=cusPassportId    1200100541999
    Input Text  id=cusPersonalId    1200100541999

    Input Text  //input[@id='addDetail' and contains(@class, 'addProfile')]        244/314
    Select From List By Index   //select[@id='addProvince' and contains(@class, 'addProfile')]     1
    Load Is Done
    Select From List By Index   //select[@id='addDistrict' and contains(@class, 'addProfile')]     4
    Load Is Done
    Input Text  //input[@id='addPostcode' and contains(@class, 'addProfile')]        244/314
    Input Text  id=conPhone     0874899811
    Input Text  id=conEmail     pakorn_traipan@icloud.com

    Input Text  //input[@id='addDetail' and contains(@class, 'addDelivery')]        244/314
    Select From List By Index   //select[@id='addProvince' and contains(@class, 'addDelivery')]     1
    Load Is Done
    Select From List By Index   //select[@id='addDistrict' and contains(@class, 'addDelivery')]     4
    Load Is Done
    Input Text  //input[@id='addPostcode' and contains(@class, 'addDelivery')]        244/314

    Select From List By Index   //select[@id='bacBanId']    0
    Input Text  id=bacNumber    12345678
    Input Text  id=bacBranch    Branch
    Select From List By Index   //select[@id='bacType']     0
    Input Text  id=bacName      Pakorn Traipan
    Select From List By Index   //select[@id='cusReferId']  ${referIndex} 
    Select From List By Index   //select[@id='cusMarital']  0
    Input Text  id=cusChild     2
    Input Text  id=cusDescedant     Pakorn Traipan

    Click Element   id=modalSaveButton
    Load Is Done
    Click Element   //button[contains(text(), 'Done')]
    
    Element Should Be Visible   //*[@id="tbodyDataList"]/tr/td[2][contains(text(), 'FullName')]

Create Order 
    [Arguments]     ${customerIndex}
    Go To               ${baseUrl}/index.php/Font-end/Account/Order
    Load Is Done
    Go To               ${baseUrl}/index.php/Font-end/Account/Order/createOrder
    Load Is Done
    Click Element   //button[contains(@class, 'addProductToCrat') and @prdid='1']
    Load Is Done
    Click Element   //button[contains(@class, 'addProductToCrat') and @prdid='1']
    Load Is Done
    Element Should Be Visible   //span[@id='sumPoint' and contains(text(), '20,000')]
    Element Should Be Visible   //span[@id='sumPrice' and contains(text(), '200')]

    Click Element   //a[contains(text(), 'Product')]
    Click Element   //button[contains(@class, 'addProductToCrat') and @prdid='1']
    Load Is Done
    Click Element   //button[contains(@class, 'addProductToCrat') and @prdid='1']
    Load Is Done
    Element Should Be Visible   //span[@id='sumPoint' and contains(text(), '40,000')]
    Element Should Be Visible   //span[@id='sumPrice' and contains(text(), '400')]

    Select From List By Index   //select[@id='customerList']   ${customerIndex} 
    Click Element   id=checkout

    Wait Until Element Is Visible   id=shipping
    Load Is Done
    Element Should Be Visible   //*[@id='tbodyInvoid']/tr/td[3][contains(text(), 'Product Test')]
    Element Should Be Visible   //*[@id='tbodyInvoid']/tr/td[4][contains(text(), '40,000')]
    Element Should Be Visible   //*[@id='tbodyInvoid']/tr/td[5][contains(text(), '400')]
    Input Text  id=shipping     100
    Press Key   id=shipping     \\13
    Load Is Done
    #Element Should Be Visible   //*[@id='tax' and contains(text(), '300')]
    #Element Should Be Visible   //*[@id='grandTotal' and contains(text(), '600')]
    Click Element   id=complete


*** Test Cases ***    
             
Login
    Open Browser        about:blank      chrome
    Clear Data
    Login               ${username}         ${password}


Create New Account With Already Username
    Go To               ${baseUrl}/index.php/Font-end/System/Account
    Load Is Done
    Click Element       id=createNewAcountButtom
    Wait Until Element Is Visible   id=modal-createNewAccount
    Input Text          id=accFirstname     firstname  
    Input Text          id=accLastname      lastname
    Input Text          id=accUsername      admin 
    Input Text          id=accPassword      password
    Click Element       id=modalSaveButton
    Load Is Done
    Wait Until Element Is Visible   //*[contains(text(), 'Username have already')]
    Element Should Be Visible   //*[contains(text(), 'Username have already')]
    Click Element   //*[@id="modal-message"]/div/div/div[3]/button

Create New Account Require Data
    Go To               ${baseUrl}/index.php/Font-end/System/Account
    Load Is Done
    Click Element       id=createNewAcountButtom
    Wait Until Element Is Visible   id=modal-createNewAccount
    Click Element       id=modalSaveButton
    Element Should Be Visible   //*[@id="createNewAccountForm"]/div[1]/span[contains(text(), 'กรุณากรอกข้อมูล')]

Create New Account
    Create New Account  firstname  lastname  username  password

Change Detail Account
    Change Detail Account  firstnameChange  lastnameChange  usernameChange  passwordChange

Change Permission And Check Permission
   Change Permission And Check Permission

Login New Account
    Logout
    Login   admin  admin

Delete Account
    Delete Account

Setting Default
    Setting Default

Setting Schedule
    Setting Schedule    1/10/2019   1/12/2019

Change Setting Schedule
    Change Setting Schedule  01/10/2018  01/10/2019

Can Not Change Setting Schedule In Working
    Go To   ${baseUrl}/index.php/Font-end/System/Setting
    Load Is Done
    Click Element  //*[@id="tbodyScheduleList"]/tr/td[13]/i[1] 
    Load Is Done
    Element Should Be Visible   //*[@id="modalMessage"]
    Click Element   //*[@id="modal-message"]/div/div/div[3]/button

Can Delete Setting Schedule In Working
    Go To   ${baseUrl}/index.php/Font-end/System/Setting
    Load Is Done
    Click Element  //*[@id="tbodyScheduleList"]/tr/td[13]/i[2] 
    Wait Until Element Is Visible   id=deleteButtonConfirm
    Click Element  id=deleteButtonConfirm
    Load Is Done
    Element Should Not Be Visible   //*[@id="tbodyScheduleList"]/tr/td[contains(text(), '01/10/2561')]
    Element Should Not Be Visible   //*[@id="tbodyScheduleList"]/tr/td[contains(text(), '01/10/2562')]

Create New Customer
    Create New Customer     Root    0

Expense From New Customer
    Go To   ${baseUrl}/index.php/Font-end/Account/Expense
    Load Is Done
    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), 'New Customer')]
    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), 'INCOME')]
    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), 'CODE : KT2018122800001 LV : S')]
    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), '100')]


Change Customer Detail
    Go To   ${baseUrl}/index.php/Font-end/Fanshine/Customer
    Load Is Done
    Click Element   //*[@id="tbodyDataList"]/tr/td[6]/i[2]
    Load Is Done
    Input Text  id=cusFullName      FullNameHasChange
    Click Element   id=modalSaveButton
    Load Is Done
    Click Element   //button[contains(text(), 'Done')]
    Element Should Be Visible   //*[@id="tbodyDataList"]/tr/td[2][contains(text(), 'FullNameHasChange')]

Uplevel Customer
    Go To      ${baseUrl}/index.php/Font-end/Fanshine/Customer
    Load Is Done
    Click Element   //*[@id="tbodyDataList"]/tr/td[6]/i[1]
    Wait Until Element Is Visible   id=modal-levelUp
    Click Element   //*[@id="buttonLevelL"]/div/center/h1
    Load Is Done
    Click Element   //button[contains(text(), 'Done')]
    Element Should Be Visible  //*[@id="tbodyDataList"]/tr/td[5][contains(text(), 'L')] 

Expense From Upgrade Customer To Level L
    Go To   ${baseUrl}/index.php/Font-end/Account/Expense
    Load Is Done
    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), 'Upgrade Customer')]
    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), 'INCOME')]
    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), '100')]

Create Child Level 1 Node A 
    Create New Customer     Child Level 1 Node A    0

Create Child Level 1 Node B 
    Create New Customer     Child Level 1 Node B    0


Create Child Level 2 Node A 
    Create New Customer     Child Level 2 Node A    1

Create Child Level 2 Node B 
    Create New Customer     Child Level 2 Node B    1

# Create Child More Than 2 Child
#     Create New Customer     Child Level 2 Node B    1

Create Location In Wherehouse
    Go To               ${baseUrl}/index.php/Font-end/Wherehouse/Location
    Load Is Done
    Click Element       id=createLocatinoButton
    Wait Until Element Is Visible   id=modal-createNewLocation
    Input Text          id=locName        A0101 
    Input Text          id=locDetail      This is room number A 
    Click Element       id=modalSaveButton
    Load Is Done
    Element Should Be Visible   //*[@id="tbodyAccountList"]/tr/td[text()='A0101']

Change Location Detail
    Go To               ${baseUrl}/index.php/Font-end/Wherehouse/Location
    Load Is Done        
    Click Element       //*[@id="tbodyAccountList"]/tr/td[4]/i[1]
    Load Is Done
    Wait Until Element Is Visible   id=modal-createNewLocation
    Input Text          id=locName        A0101 
    Input Text          id=locDetail      This is room number A on second floor
    Click Element       id=modalSaveButton
    Load Is Done
    Element Should Be Visible   //*[@id="tbodyAccountList"]/tr/td[text()='This is room number A on second floor']

Create Product In Wherehouse
    Go To               ${baseUrl}/index.php/Font-end/Wherehouse/Product
    Load Is Done
    Click Element       id=createNewProductButton
    Wait Until Element Is Visible   id=modal-createNewProduct
    Input Text          id=matName        Product Test 
    Select From List By Index   //select[@id='matLocId']    0
    Select From List By Index   //select[@id='matUntId']    0
    Select From List By Index   //select[@id='matType']     0
    Input Text          id=matMin        10 
    Input Text          id=matMax        100 
    Click Element       id=modalSaveButton
    Load Is Done
    Element Should Be Visible   //*[@id="tbodyAccountList"]/tr/td[text()='Product Test']

    
Change Product Detail In Wherehouse
    Go To               ${baseUrl}/index.php/Font-end/Wherehouse/Product
    Load Is Done
    Click Element       //*[@id="tbodyAccountList"]/tr/td[9]/i[1]
    Load Is Done
    Wait Until Element Is Visible   id=modal-createNewProduct
    Input Text          id=matName        Product Test 
    Select From List By Index   //select[@id='matLocId']    0
    Select From List By Index   //select[@id='matUntId']    1
    Select From List By Index   //select[@id='matType']     1
    Input Text          id=matMin        10 
    Input Text          id=matMax        100 
    Click Element       id=modalSaveButton
    Load Is Done
    Element Should Be Visible   //*[@id="tbodyAccountList"]/tr/td[text()='Product Test']

Out Of Stock Should Be Red Highlight
    Go To               ${baseUrl}/index.php/Font-end/Wherehouse/Stock
    Load Is Done
    Element Should Be Visible   //*[@id="tableStockList"]/tr[contains(@class, 'alert-danger')]

Input Stock
    Go To               ${baseUrl}/index.php/Font-end/Wherehouse/Stock
    Load Is Done
    Click Element       //*[@id="tableStockList"]/tr/td[7]/span[1]
    Load Is Done
    Wait Until Element Is Visible   id=modal-inputStock
    Input Text          id=matAmount      5
    Input Text          id=matCost        10 
    Select From List By Index   //select[@id='matLocId']    0
    Input Text          id=matExpDate     14/01/2019
    Input Text          id=stoReason      Test System
    Click Element       id=actionInputStock
    Load Is Done
    Element Should Be Visible   //*[@id="tableStockList"]/tr/td[5][contains(text(),'5')]

Refils Stock Should Be Yellow Highlight
    Go To               ${baseUrl}/index.php/Font-end/Wherehouse/Stock
    Load Is Done
    Element Should Be Visible   //*[@id="tableStockList"]/tr[contains(@class, 'alert-warning')]

Input Stock Again
    Go To               ${baseUrl}/index.php/Font-end/Wherehouse/Stock
    Load Is Done
    Click Element       //*[@id="tableStockList"]/tr/td[7]/span[1]
    Load Is Done
    Wait Until Element Is Visible   id=modal-inputStock
    Input Text          id=matAmount      20
    Input Text          id=matCost        10 
    Select From List By Index   //select[@id='matLocId']    0
    Input Text          id=matExpDate     14/01/2019
    Input Text          id=stoReason      Test System
    Click Element       id=actionInputStock
    Load Is Done
    Element Should Be Visible   //*[@id="tableStockList"]/tr/td[5][contains(text(),'25')]

Output Stock
    Go To               ${baseUrl}/index.php/Font-end/Wherehouse/Stock
    Load Is Done
    Click Element       //*[@id="tableStockList"]/tr/td[7]/span[2]
    Load Is Done
    Wait Until Element Is Visible   id=modal-outputStock
    Input Text          class=matAmountOutput      10
    Select From List By Index   //select[@id='matLocId']    0
    Input Text          //*[@id="modal-outputStock"]//input[@id="stoReason"]      Test System
    Click Element       id=actionOutputStock
    Load Is Done
    Element Should Be Visible   //*[@id="tableStockList"]/tr/td[5][contains(text(),'15')]

Create Product Account
    Go To               ${baseUrl}/index.php/Font-end/Account/Product
    Load Is Done
    Click Element       id=createNewProductButton
    Wait Until Element Is Visible   id=modal-createNewProduct
    Input Text          id=prdFullPrice       110 
    Load Is Done
    Input Text          id=prdDiscount        10 
    Load Is Done
    Click Element       id=searchMaterial
    Load Is Done
    Click Element   //button[@id="modalSaveButton"]
    Load Is Done
    Wait Until Element Is Not Visible   id=modalSaveButton
    Element Should Be Visible   //*[@id="tbodyProductList"]/tr/td[contains(text(), 'MT00001')]

Create Order 
    Go To               ${baseUrl}/index.php/Font-end/Account/Order
    Load Is Done
    Go To               ${baseUrl}/index.php/Font-end/Account/Order/createOrder
    Load Is Done
    Click Element   //button[contains(@class, 'addProductToCrat') and @prdid='1']
    Load Is Done
    Click Element   //button[contains(@class, 'addProductToCrat') and @prdid='1']
    Load Is Done
    Element Should Be Visible   //span[@id='sumPoint' and contains(text(), '20,000')]
    Element Should Be Visible   //span[@id='sumPrice' and contains(text(), '200')]

Check My Order
    Click Element   //a[contains(text(), 'My Order')]
    Element Should Be Visible   //*[@id="myProductCategory"]/div/div/div[3]/div[3]/center/span[contains(text(), '2')]

Minus Item From Cart
    Click Element   //*[@id="myProductCategory"]/div/div/div[3]/div[2]/button
    Load Is Done
    Element Should Be Visible   //*[@id="myProductCategory"]/div/div/div[3]/div[3]/center/span[contains(text(), '1')]

Remove Item From Cart
    Click Element   //button[contains(@class, 'removeOrder') and @prdid='1']
    Load Is Done
    Element Should Not Be Visible   //button[contains(@class, 'removeOrder') and @prdid='1']

Add Item To Cart
    Click Element   //a[contains(text(), 'Product')]
    Click Element   //button[contains(@class, 'addProductToCrat') and @prdid='1']
    Load Is Done
    Click Element   //button[contains(@class, 'addProductToCrat') and @prdid='1']
    Load Is Done
    Element Should Be Visible   //span[@id='sumPoint' and contains(text(), '20,000')]
    Element Should Be Visible   //span[@id='sumPrice' and contains(text(), '200')]

Checkout Without Select Customer
    Click Element   id=checkout
    Wait Until Element Is Visible   id=modal-message
    Element Should Be Visible   //p[contains(text(), 'Select customer for this order')]
    Click Element   //*[@id="modal-message"]/div/div/div[3]/button
    Wait Until Element Is Not Visible   id=modal-message

Search Customer By Name Not Found Customer
    Input Text  id=searchCustomer   Not Found
    Load Is Done
    Press Key   id=searchCustomer   \\13
    Load Is Done
    Element Should Not Be Visible   //*[@id="customerList"]/option[2]

Search Product By Name Not Found
    Input Text  id=search   Not Found
    Press Key   id=search   \\13
    Load Is Done
    Element Should Not Be Visible   //p[contains(text(), 'MT00001')]

Search Product By Code Is Found
    Input Text  id=search   MT00001
    Press Key   id=search   \\13
    Load Is Done
    Element Should Be Visible   //p[contains(text(), 'MT00001')]

Checkout With Select Customer
    Input Text  id=searchCustomer   FullNameHasChange
    Press Key   id=searchCustomer   \\13
    Load Is Done
    Select From List By Index   //select[@id='customerList']    1
    Click Element   id=checkout

    Wait Until Element Is Visible   id=shipping
    Load Is Done
    Element Should Be Visible   //*[@id='tbodyInvoid']/tr/td[3][contains(text(), 'Product Test')]
    Element Should Be Visible   //*[@id='tbodyInvoid']/tr/td[4][contains(text(), '20,000')]
    Element Should Be Visible   //*[@id='tbodyInvoid']/tr/td[5][contains(text(), '200')]
    Input Text  id=shipping     100
    Press Key   id=shipping     \\13
    Load Is Done
    Element Should Be Visible   //*[@id='tax' and contains(text(), '300')]
    Element Should Be Visible   //*[@id='grandTotal' and contains(text(), '600')]
    Click Element   id=complete

Create Order For Child
    Create Order    2
    Create Order    3
    Create Order    4

Update Status Of Order To Pay Already
    Go To           ${baseUrl}/index.php/Font-end/Account/Order
    Load Is Done
    Click Element   //*[@id="tbodyOrderList"]/tr[1]/td[6]/i[3]
    Load Is Done
    Element Should Be Visible   //*[@id="tbodyOrderList"]/tr[1]/td[5]/span[contains(text(), 'Pay Already')]

Update Status Of Order To Shipping
    Click Element   //*[@id="tbodyOrderList"]/tr[1]/td[6]/i[3]
    Load Is Done
    Element Should Be Visible   //*[@id="tbodyOrderList"]/tr[1]/td[5]/span[contains(text(), 'Shipping')]

Update Status Of Order To Ship Already
    Click Element   //*[@id="tbodyOrderList"]/tr[1]/td[6]/i[3]
    Load Is Done
    Element Should Be Visible   //*[@id="tbodyOrderList"]/tr[1]/td[5]/span[contains(text(), 'Ship Already')]

History Is Correct
    Go To   ${baseUrl}/index.php/Font-end/Account/History
    Load Is Done
    Element Should Be Visible   //*[@id="tbodyOrderList"]/tr/td[3][contains(text(), 'FullNameHasChange')]
    Element Should Be Visible   //*[@id="tbodyOrderList"]/tr/td[4][contains(text(), '600')]
    Element Should Be Visible   //*[@id="tbodyOrderList"]/tr/td[5]/span[contains(text(), 'Waiting Pay')]

Update Order To Expense
    Go To           ${baseUrl}/index.php/Font-end/Account/Order
    Load Is Done
    Click Element   //*[@id="tbodyOrderList"]/tr[1]/td[6]/i[5]
    Load Is Done
    Element Should Not Be Visible   //*[@id="tbodyOrderList"]/tr[1]/td[6]/i[5]

    Go To   ${baseUrl}/index.php/Font-end/Account/Expense
    Load Is Done
    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), 'รายการสั่งซื้อ')]
    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), 'INCOME')]
    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), '1000')]

Public Commission Created
    Go To   ${baseUrl}/index.php/Font-end/Fanshine/Commission
    Load Is Done
    Element Should Be Visible   //*[@id="tbodyCommissionList"]/tr[1]/td[6][contains(text(), '40,000')]
    Element Should Be Visible   //*[@id="tbodyCommissionList"]/tr[1]/td[7][contains(text(), '40,000')]
    Element Should Be Visible   //*[@id="tbodyCommissionList"]/tr[1]/td[8][contains(text(), '4,000,000')]

Private Commission Created
    Go To   ${baseUrl}/index.php/Font-end/Fanshine/Commission
    Load Is Done
    Element Should Be Visible   //*[@id="tbodyCommissionList"]/tr[2]/td[5][contains(text(), '40,000')]
    Element Should Be Visible   //*[@id="tbodyCommissionList"]/tr[2]/td[7][contains(text(), '40,000')]
    Element Should Be Visible   //*[@id="tbodyCommissionList"]/tr[2]/td[8][contains(text(), '4,000,000')]

Expense Is Correct
    Go To   ${baseUrl}/index.php/Font-end/Account/Expense
    Load Is Done
    #Element Should Be Visible   //span[@id='incomeAmount' and contains(text(), '200')]
    Element Should Be Visible   //span[@id='expenseAmount' and contains(text(), '0')]
    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), 'Upgrade Customer')]
    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), 'INCOME')]
    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), '100')]

    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), 'New Customer')]
    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), 'INCOME')]
    Element Should Be Visible   //*[@id="tbodyList"]/tr/td[contains(text(), '100')]

#Clear Data
    #Clear Data




