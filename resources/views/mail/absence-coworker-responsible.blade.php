                              @include('mail.components.mail-header')
                                   @if ($dataObj->msg_type == 'absence')
                                  <p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">Below are some datails of your absence call, please report to your line manager or responsible on your first day back to work, from the entire IC-admin Sheffield team we wish you well soon.</p>
                                  @endif
                                  @if ($dataObj->msg_type == 'responsible')
                                  <p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">We've had absence call from <span style="font-weight:bold;">{{$dataObj->co_worker_name}}</span>, please find the details below thank you.</p>
                                  @endif 
                                     </td>
                                     </tr>
                                      <tr>
                                      <td valign="top" class="textContent">
                                      <p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:100%; font-weight:bold;">Absence Reference: <span style="font-weight:normal;">{{$dataObj->reference_number}} </span> </p>
                                         <p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:20px;color:#5F5F5F;line-height:100%; font-weight:bold;">Date called: <span style="font-weight:normal;">{{$dataObj->date}} </span></p>
                                         <p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:100%; font-weight:bold;">Time approximately called: <span style="font-weight:normal;">{{$dataObj->time}} </span> </p>
                                         <p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:100%; font-weight:bold;">Absence for: <span style="font-weight:normal;">{{$dataObj->date_for}} </span> </p>
                                         <p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:100%; font-weight:bold;">Shift start: <span style="font-weight:normal;">{{$dataObj->shift_start_time}} </span> </p>
                                         <p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:100%; font-weight:bold;">Shift end: <span style="font-weight:normal;">{{$dataObj->shift_end_time}} </span> </p>
                                         @if ($dataObj->msg_type == 'responsible')
                                        
                                         <p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:100%; font-weight:bold;">Reason: <span style="font-weight:normal;">{{$dataObj->absence_reason}} </span> </p>
                                         <p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:100%; font-weight:bold;">Work related: <span style="font-weight:normal;">{{$dataObj->work_related}} </span> </p>
                                         <p style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:10px;color:#5F5F5F;line-height:100%; font-weight:bold;">Comment: <span style="font-weight:normal;">{{$dataObj->comment}} </span> </p> 
                                         @endif
                                        </td>

                                      </tr>


                                      

@include('mail.components.mail-footer')
