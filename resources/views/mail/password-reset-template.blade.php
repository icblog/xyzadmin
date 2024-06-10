@include('mail.components.mail-header')


<p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">Welcome to ic-admin, click on the button below to reset your password, for security reasons this link will expired in 20mins but contact us if you need further help.</p>
                                        </td>
                                      
                                      </tr>
                    
                                      <tr>
                                        <td align="center" valign="middle" class="buttonContent" style="padding-top:10px;padding-bottom:10px;padding-right:10px;padding-left:10px;">
                                          <a style="color:#FFFFFF;text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:100%;" href="{{$dataObj->link}}" target="_blank">Reset password</a>
                                        </td>
                                      </tr>
                                   
@include('mail.components.mail-footer')
