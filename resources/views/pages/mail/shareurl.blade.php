<center>
	<table border="0" cellpadding="8" cellspacing="0" style="padding:0;width:100%!important;background:#ffffff;margin:0;background-color:#ffffff">
		<tbody>
			<tr>
				<td valign="top">
					<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-radius:4px;border:1px #cacaca solid">
						<tbody>
							<tr>
								<td colspan="3" height="6"></td>
							</tr>
							<tr>
								<td>
									<table align="center" border="0" cellpadding="0" cellspacing="0" style="line-height:25px">
										<tbody>
											<tr>
												<td colspan="3" height="30"></td>
											</tr>
											<tr>
												<td width="36"></td>
												<td align="left" style="color:#444444;border-collapse:collapse;font-size:11pt;font-family:proxima_nova,'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif';max-width:454px" valign="top" width="454">
													<p>Hello,</p>
													<p>{{$data['user_name']}} (<a href="{{$data['sender_mail']}}" target="_blank">{{$data['sender_mail']}}</a>) has invited you to view a Private Room
														<b>{{$data['room_name']}}</b> on Arte Index.
													</p>
                                                    @if(isset($data['message']))
													<div style="font-style:italic;font-size:0.9em">
														<p>{{$data['message']}}</p>
													</div>
                                                    @endif
													<br>
														<a href="{{$data['room_url']}}" style="border-radius:5px;font-size:14px;color:white;text-decoration:none;padding:12px 4px 12px 4px;width:150px;max-width:150px;font-family:proxima_nova,'Open Sans','lucida grande','Segoe UI',arial,verdana,'lucida sans unicode',tahoma,sans-serif;margin:12px auto;display:block;background-color:#008cba;text-align:center" target="_blank" >View Private Room</a>
													</td>
													<td width="36"></td>
												</tr>
												<tr>
													<td colspan="3" height="36"></td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
						<table align="center" border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr>
									<td height="10"></td>
								</tr>
								<tr>
									<td style="padding:0;border-collapse:collapse">
										<table align="center" border="0" cellpadding="0" cellspacing="0">
											<tbody>
												<tr style="color:#acacac;font-size:11px;font-family:proxima_nova,'Open Sans','Lucida Grande','Segoe UI',Arial,Verdana,'Lucida Sans Unicode',Tahoma,'Sans Serif'">
													<td align="left" width="200"></td>
													<td align="right" width="328">
    Powered by Arte Index.
    </td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</center>
