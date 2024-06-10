
<p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">Welcome to xyz ltd, below are your login details for the admin section, contact us if you need further help.</p>
                                        </td>
                                      
                                      </tr>
                                      <tr>
                                      <td valign="top" class="textContent">
                                         
                                         <p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:100%; font-weight:bold;">Username: <span style="font-weight:normal;">{{$dataObj->username}} </span><span style="font-weight:bold;">or <span> <span style="font-weight:normal;"> {{$dataObj->email}} </span></p>
                                         <p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:100%; font-weight:bold;">Password: <span style="font-weight:normal;">{{$dataObj->password}} </span> </p> 
                                       </td>

                                        
                                        <!-- <td valign="top" class="textContent">
                                         
                                          <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:100%; font-weight:bold;">Username: </div>
                                          <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:100%;">jsde_90 </div>
                                          <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:100%; font-weight:bold;">Password</div>
                                          <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:100%;">gdyte6474</div>
                                        </td> -->

                                      </tr>
                                    </table>
                                    <table border="0" cellpadding="0" cellspacing="0" width="30%" class="emailButton" style="background-color: #000000; margin-top:50px;">
                                      <tr>
                                        <td align="center" valign="middle" class="buttonContent" style="padding-top:10px;padding-bottom:10px;padding-right:10px;padding-left:10px;">
                                          <a style="color:#FFFFFF;text-decoration:none;font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:100%;" href="{{url('/login')}}" target="_blank">Login</a>
                                        </td>
                                      </tr>
                                   
              <!-- divider -->
              <!-- <tr>
                <td align="center" valign="top">
                  <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                      <td align="center" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" width="600" class="flexibleContainer">
                          <tr>
                            <td align="center" valign="top" width="600" class="flexibleContainerCell">
                              <table class="flexibleContainerCellDivider" border="0" cellpadding="30" cellspacing="0" width="100%">
                                <tr>
                                  <td align="center" valign="top" style="padding-top:0px;padding-bottom:0px;">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                      <tr>
                                        <td align="center" valign="top" style="border-top:1px solid #C8C8C8;"></td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr> -->
              <!-- // end of divider -->
@include('mail.components.mail-footer')
