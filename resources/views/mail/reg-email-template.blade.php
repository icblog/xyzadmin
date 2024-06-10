@include('mail.components.mail-header')

<p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">Welcome to ic-admin, below are your login details for the admin section, contact us if you need further help.</p>
                                        </td>
                                      
                                      </tr>
                                      <tr>
                                      <td valign="top" class="textContent">
                                         
                                         <p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:100%; font-weight:bold;">Username: <span style="font-weight:normal;">{{$dataObj->username}} </span><span style="font-weight:bold;">or <span> <span style="font-weight:normal;"> {{$dataObj->email}} </span></p>
                                         <p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:100%; font-weight:bold;">Password: <span style="font-weight:normal;">{{$dataObj->password}} </span> </p> 
                                       </td>

                                      </tr>
                                       <tr>
                                        <td align="center" valign="middle" class="buttonContent" style="padding-top:10px;padding-bottom:10px;padding-right:10px;padding-left:10px;">
                                          <a style="color:#FFFFFF;text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:100%;" href="{{url('/login')}}" target="_blank">Login</a>
                                        </td>
                                      </tr>
                                   

@include('mail.components.mail-footer')
