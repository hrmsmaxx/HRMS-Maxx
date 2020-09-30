

function nextMultiple(num,mult)
{if(typeof(mult)=="undefined")
mult=5;var up=0;var rnd=Math.round(parseInt(num)/mult)*mult;if(num>rnd)
up=num+(mult-(num-rnd));else
up=num+(rnd-num);return up;}

function UpdatePaymentTerm()
{iPaymentTerm=($("#my").prop("checked")==true)?1:0;if(iPaymentTerm==0)
{$("#divYB").css("color","#b9b9b9");$("#divMB").css("color","#1eb53a");$("#btnMain").html("Sign Up on Monthly Plan");}
else
{$("#divMB").css("color","#b9b9b9");$("#divYB").css("color","#1eb53a");$("#btnMain").html("Sign Up on Yearly Plan & Save");}}

function UpdatePrice()
{if(iSubscriptionFor>=990)iSubscriptionFor=1000;UpdatePaymentTerm();var p=CalculateHrmsMaxxPricing(iSubscriptionFor);dPrice=(p.price*iSubscriptionFor);dPricePerEmployee=(dPrice/iSubscriptionFor);dAddOnModulesPrice=0;for(i=0;i<iAddOnModules;i++)
{if(aAddOnModules_Status[i]==1)
{dAddOnModulesPrice+=parseFloat(aAddOnModules_Price[i]);}}
$("#mp_Base").html("$ "+dPricePerEmployee.toFixed(2));dPricePerEmployee=dPricePerEmployee+dAddOnModulesPrice;$("#emp").text(iSubscriptionFor+" Empleados");$("#ppe").text("por empleado / mes");$(".ppm").html("$ "+dPricePerEmployee.toFixed(2));dDocumentsStorage=(iSubscriptionFor*100);if(dDocumentsStorage>1024)
sDocumentsStorage=(dDocumentsStorage/1024).toFixed(2)+" GB";else
sDocumentsStorage=dDocumentsStorage+" MB";$("#ds").html("Capacidad de almacenamiento: "+sDocumentsStorage);}

function CalculateHrmsMaxxPricing(iEmployees)
{var dCost=0;var iStep=5;var iStepDecrementFactor=0,price=0;var lbound="0",ubound="0";if(iPaymentTerm==0)
var pricing={"5":3.00,"1000":2.00};else
var pricing={"5":2.00,"1000":1.00};iEmployees=nextMultiple(iEmployees,iStep);lbound="5";ubound="1000";iStepDecrementFactor=(pricing[lbound]-pricing[ubound])/((ubound-lbound)/iStep);return{"employees":iEmployees,"price":pricing[lbound]-(((iEmployees-lbound)/iStep)*iStepDecrementFactor)};}

function MoreAddOnModules()
{$(".trMoreAddOnModules").show();$(".trMoreAddOnModulesLink").hide();$(".trLessAddOnModulesLink").show();}

function LessAddOnModules()
{$(".trMoreAddOnModules").hide();$(".trMoreAddOnModulesLink").show();$(".trLessAddOnModulesLink").hide();}

function HrmsMaxxSelectPlan(iPlanType)
{if(iPlanType==0)
window.location="signup.php?plan=Free";else
{sAddOnModules="";for(i=0;i<iAddOnModules;i++)
{if(aAddOnModules_Status[i]==1)
{sAddOnModules+=aAddOnModules[i]+"|";}}
sData="plan=Paid";sData+="&emp="+iSubscriptionFor;sData+="&pt="+iPaymentTerm;sData+="&aom="+sAddOnModules;window.location="signup.php?"+sData;}}

function HrmsMaxxUpgrade(sOrganizationCode,sAuthCode)
{sAddOnModules="";for(i=0;i<iAddOnModules;i++)
{if(aAddOnModules_Status[i]==1)
{sAddOnModules+=aAddOnModules[i]+"|";}}
sData="plan=Paid";sData+="&org="+sOrganizationCode;sData+="&emp="+iSubscriptionFor;sData+="&pt="+iPaymentTerm;sData+="&aom="+sAddOnModules;sData+="&ordertype=Upgrade";sData+="&code="+sAuthCode;window.location="https://HrmsMaxx.co/payment.php?"+sData;}

function OrderNow(){window.location.href="signup.php?plan=Paid&emp="+iEmployeesPerMonth+"&pt="+$("#pt").val();}
function jsOpenWindow(filename,width,height)
{window.open(filename,"Window_"+Math.floor(Math.random()*110),"toolbar=no,width="+width+",height="+height+",directories=no,status=yes,location=no,scrollbars=yes,resizable=yes,menubar=no");}
function ScrollTo(sAnchor)
{$("html,body").animate({scrollTop:$("#"+sAnchor).offset().top},"slow");}
function SAlert(sMessage,sFieldName)
{$("#"+sFieldName).focus();Swal.fire("",sMessage,"error");return(false);}
function SAlertInfo(sMessage,sFieldName)
{$("#"+sFieldName).focus();Swal.fire("",sMessage,"info");return(false);}
function AjaxPage(url,containerid)
{$("#"+containerid).html('<br /><br /><div align="center"><img src="'+cCDN+'/images/Loading/loading.gif" /></div><br /><br />');$("#"+containerid).load(url);}
