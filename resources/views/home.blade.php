@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-md navbar-dark bg-dark bg-gradient shadow">
    <div class="container d-flex justify-content-center">
        <div style="display: flex;">
                <div class="nav-item px-1">
                    <a href="#sales_submit" class="nav-link" style="color:white">{{$lang->h_link_1}}</a>
                </div>
                <div class="nav-item px-1">
                    <a href="#rule" class="nav-link" style="color:white" >{{$lang->h_link_2}}</a>
                </div>
                <div class="nav-item px-1">
                    <a href="#contact" class="nav-link" style="color:white">{{$lang->h_link_3}}</a>
                </div>
                <div class="nav-item px-1">
                    <a class="nav-link" id="cglang" style="color:white"><form method="POST" action="{{route('changelang')}}">@csrf<input type="hidden" class="" name="lgflag" value="{{$lang->lang}}"><input type="hidden" name="memberid" value="{{$uth->memberid}}" ><button class="lanbtn" type="submit">{{$lang->h_link_4}}</button></form></a>
                </div>    
        </div>
    </div>
</nav>
<div class="bswrap">
    <div class="pt-5 mt-5">
        <div class="container">
            <h2 class="text-center pb-2">{{$lang->h_title}} {{ $uth->f_name}} {{$uth->l_name}}</h2>
            <p class="f4 text-justify">{{$lang->h_s_tit_1}} ${{$totalsp[0]->tospiff}} {{$lang->h_s_tit_1_1}}. {{$lang->h_s_tit_2}}</p>
            <p class="f4">{{$lang->h_s_tit_3}}<b>{{$lang->h_s_tit_4}}</b></p>
            <div class="card">
                <h3 class="text-start p-3">{{$lang->h_link_0}}</h3>
                <div class="table-responsive">
                    <table class="tbl table table-centered table-nowrap">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center" style="width: 10%;">#</th>
                                <th class="text-center" style="width: 15%;">{{$lang->in_t01}}</th>
                                <th class="text-center" style="width: 15%;">{{$lang->in_t11}}</th>
                                <th class="text-center" style="width: 15%;">{{$lang->in_t13}}</th>
                                <th class="text-center" style="width: 15%;">{{$lang->in_t02}}</th>
                                <th class="text-center" style="width: 15%;">{{$lang->in_t03}}</th>
                                <th class="text-center" style="width: 15%;">{{$lang->in_t12}}</th>
                            </tr>
                        </thead>
                        <tbody id="invtbl">
                            @foreach($invresult as $key => $idata)
                            <tr id="inv_{{ $idata->sale_num }}" trid="{{ $idata->sale_num }}">
                                <td class="text-center">{{ $key+1 }}</td>
                                <td class="text-center">{{ $idata->sale_num }}</td>
                                <td class="text-center">{{ $idata->tsnum }}</td>
                                <td class="text-center">${{ $idata->tspiff }}</td>
                                <td class="text-center">{{ $idata->in_num }}</td>
                                <td class="text-center">{{ $idata->in_date }}</td>
                                <td class="text-center">{{ $idata->tsale }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-flex justify-content-end align-items-center">
                @if($msg != "start")
                <div id="msg" class=" bg-secondary rounded-3 w-100 py-1 px-2 text-center align-item-center my-3 position-relative">
                    <p class="fs-4 mt-2 text-white">{{$msg}}</p>
                    <p id="msgbtn" class="fs-4 ml-auto position-absolute translate-middle top-50 end-0 text-white">&#x2716;</p>
                </div>
                @endif
            </div>
            <div id ="sales_submit"  class="pt-5 mt-5">
            <div class="card">
                <form method="post" action="{{ route('sendinvoice') }}" enctype="multipart/form-data" class="was-validated card-body m-2">
                @csrf
                    <h3 class="text-start p-3">{{$lang->h_link_1}}</h3>
                    <p class="f4 text-justify">Enter all required information along with a copy of the sales invoice below. Remember, only sales that have been delivered can be approved. Please keep PDF to a max of 5MB. Thank you for Submission</p>
                    <input type="hidden" id="memberuth" name="memberuth" class="memberuth" value="{{$uth->memberid}}">
                    <input type="hidden" id="langf" name="lgflag" value="{{$lang->lang}}">
                    <div class="row m-1">
                            <div class="col-sm-6">
                                <p class="f4 w-100"><b>{{$lang->in_t01}}:</b></p>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control w-100 snum" id="snum" name="snum" value="{{$maxsn}}" type="text" placeholder="{{$lang->in_t01}}" disabled>
                                <input type="hidden" value="{{$maxsn}}" name="salenum" id="salenum">
                            </div>
                        </div>

                        
                        <div class="row m-1">
                            <div class="col-sm-6">
                                <p class="f4 w-100"><b>{{$lang->in_t02}}:</b></p>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control w-100 innum" id="innum" name="innum" type="text" placeholder="{{$lang->in_t02}}" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        
                         <div class="row m-1">
                            <div class="col-sm-6">
                                <p class="f4 w-100">{{$lang->in_t03}}:</p>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control w-100 indate" id="indate" type="date" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>

                        
                        <div class="row m-1">
                            <div class="col-sm-6">
                                <p class="f4 w-100">{{$lang->in_t04}}</p>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control w-100 infile" id="infile" name="file" type="file" placeholder="link" required>
                                <div class="valid-feedback">Valid.</div>
                                <div class="invalid-feedback">Please fill out this field.</div>
                            </div>
                        </div>
                        <hr>
                        <div class="row m-1">
                            <div class="col-sm-6">
                                <p class="f4 w-100">{{$lang->in_t05}}:</p>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control w-100 series" id="series" type="text" placeholder="{{$lang->in_t05}}" require>
                            </div>
                        </div>
                        <div class="row m-1">
                            <div class="col-sm-6">
                                <p class="f4 w-100">{{$lang->in_t06}}:</p>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control w-100 dedate" id="dedate" type="date" require>
                            </div>
                        </div>
                        <div class="row m-1">
                            <div class="col-sm-6">
                                <p class="f4 w-100">{{$lang->in_t07}}:</p>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control w-100 mdnum" id="mdnum" type="text" placeholder="{{$lang->in_t07}}" require>
                                <div class="table-responsive restb">
                                    <table class="tbl table table-centered table-nowrap">
                                        <tbody id="skulist"><tr><td>model number list</td></tr></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row m-1">
                            <div class="col-sm-6">
                                <p class="f4 w-100">{{$lang->in_t08}}:</p>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control w-100 prodes" id="prodes" type="text" placeholder="{{$lang->in_t08}}" disabled>
                            </div>
                        </div>
                        
                        <div class="row m-1">
                            <div class="col-sm-6">
                                <p class="f4 w-100">{{$lang->in_t09}}:</p>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control w-100 spiff" id="spiff" type="text" placeholder="{{$lang->in_t09}}" disabled>
                            </div>
                        </div>

                        <div class="row m-1">
                            <div class="col-sm-6">
                                <p class="f4 w-100">{{$lang->in_t10}}:</p>
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control w-100 salepricce" id="saleprice" type="text" placeholder="{{$lang->in_t10}}" >
                            </div>
                        </div>
                        <div class="row justify-content-end"><div class="col-md-6"><a id="add_salepro" class="w-100 btn btn-secondary p-3 ">{{$lang->in_t15}}</a></div></div>
                        <div class="row py-3">
                            <div class="table-responsive">
                                <table class="tbl table table-centered table-nowrap">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center" style="width: 5%;">#</th>
                                            <th class="text-center" style="width: 10%;">{{$lang->in_t07}}</th>
                                            <th class="text-center" style="width: 45%;">{{$lang->in_t08}}</th>
                                            <th class="text-center" style="width: 10%;">{{$lang->in_t09}}</th>
                                            <th class="text-center" style="width: 10%;">{{$lang->in_t10}}</th>
                                            <th class="text-center" style="width: 20%;">{{$lang->in_t05}}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="protbl"></tbody>
                                </table>
                            </div>
                            <button id="" type="submit" class="btn btn-secondary p-3">Submit Invoice</button>
                        </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    <div id="rule" class="py-5">
        <div class="container py-5">
            <div class="card bg-dark bg-gradient">
                <div class="card-body text-white p-4">
                    <h3 class="text-center text-warning p-1">DACOR Rewards Rules</h3>
                    <p class="f4 text-justify text-wrap">Only authorized Sales Associates directly enrolled by a Samsung representative may participate in the DACOR Rewards program. </p>
                    <p class="f4 text-justify">Program runs from March 9th to Dec 31st 2022. Sales to be accepted until Jan 31st 2023.</p>
                    <p class="f4 text-justify">Sales associate must claim within 30 days of the delivery to the end user. Between March 9th – April 9th 2022, deliveries are an exception to the 30 day rule.</p>
                    <p class="f4 text-justify">Claims will only be processed by the Delivery Date of the item, not Sale date. In order for a submission to be valid, submission must show delivery date on the invoice and include the  serial numbers of the relevant DACOR models delivered.</p>
                    <p class="f4 text-justify">Only DACOR models listed on rewardsdacor.com are eligible to earn rewards. Current model list and incentive amounts are listed here:</p>
                    <p class="f4 text-justify">All earned rewards are counted as income. A T4A will be issued to anyone who earns a sales incentive reward cheque. Cheques will not be issued to sales associates who do not provide their SIN number.</p>
                    <p class="f4 text-justify">If the results of any audit leads to a suspicion or confirmation of any incorrect, deceptive or fraudulent activity, a sales associate will be removed from the program and have any sales incentive earning cancelled.</p>
                    <p class="f4 text-justify">Earnings will be processed monthly. Please allow 6 to 8 weeks for your cheque to arrive.</p>
                    <p class="f4 text-justify">If you have any questions please use the contact page.</p>
                </div>
            </div>
        </div>
    </div>
    <div id="contact" class="scontact py-5" >
        <form method="post" action="{{ route('sendtemail') }}"  class="my-form was-validate">
        @csrf
            <div class="container pt-3 pb-5">
                <input type="hidden" name="muth" value="{{$uth->memberid}}">
                <input type="hidden" name="lgflag" value="{{$lang->lang}}">
                <h1 class="text-center text-white pt-3">{{$lang->ct_te_1}}</h1>
                <p class="fs-4 text-center text-info pb-5">{{$lang->ct_te_2}}</p>
                <ul>
                    <li>
                        <div class="grid grid-2">
                        <input type="text" id="cname" name="cname" placeholder="Name" value="MemberID: {{$uth->memberid}}" disabled>
                        <input type="email" id="cemail" name="cemail" placeholder="{{$lang->ct_bt_00}}" required>
                        </div>
                    </li>
                    <li>
                        <input type="text" id="ctitle" name="ctitle" placeholder="{{$lang->ct_bt_01}}" require>
                    </li>    
                    <li>
                        <textarea id="ctext" name="ctext" placeholder="{{$lang->ct_bt_02}}"></textarea>
                    </li>   
                    <li>
                        <input type="checkbox" id="terms">
                        <label for="terms">{{$lang->ct_te_3}} <a href="#rule">{{$lang->h_link_2}}s</a>.</label>
                    </li>  
                    <li>
                        <div class="grid grid-3">
                        <div class="required-msg"></div>
                        <button  class="btn-grid" type="submit" disabled>
                            <span class="back">
                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/162656/email-icon.svg" alt="">
                            </span>
                            <span class="front">{{$lang->ct_t_01}}</span>
                        </button>
                        <button class="btn-grid" type="reset" disabled>
                            <span class="back">
                            <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/162656/eraser-icon.svg" alt="">
                            </span>
                            <span class="front">{{$lang->ct_t_02}}</span>
                        </button> 
                        </div>
                    </li>
                </ul>
            </div>
        </form>
    </div>
</div>


<!-- Modal -->
<div class="modal" id="myModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title" id="invname">Detail Invoice</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <div class="table-responsive">
                <table class="tbl table table-centered table-nowrap">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="width: 10%;">{{$lang->in_t01}}</th>
                            <th class="text-center" style="width: 40%;">{{$lang->in_t08}}</th>
                            <th class="text-center" style="width: 10%;">{{$lang->in_t03}}</th>
                            <th class="text-center" style="width: 10%;">{{$lang->in_t06}}</th>
                            <th class="text-center" style="width: 10%;">{{$lang->in_t10}}</th>
                            <th class="text-center" style="width: 10%;">{{$lang->in_t09}}</th>
                            <th class="text-center" style="width: 10%;">Status</th>
                        </tr>
                    </thead>
                    <tbody id="invdetail"></tbody>
                </table>
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>

<script>
    const checkbox = document.querySelector('.my-form input[type="checkbox"]');
    const btns = document.querySelectorAll(".my-form button");

    checkbox.addEventListener("change", function() {
    const checked = this.checked;
    for (const btn of btns) {
        checked ? (btn.disabled = false) : (btn.disabled = true);
    }
    });
    $('#msgbtn').click(function(){
        $('#msg').css({"display" : "none"} );
    });


    $('#invtbl tr').click(function (){
        var sale_num =$(this).attr('trid');
        var shtml='';
        $('#invdetail').html(shtml);
        $('#myModal').modal('show');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('getdetailinv') }}",
            type: "POST",
            data: { sale_num : sale_num},
            dataType: "json",
            success: function(result){
                const { results } = result;
                if(results.length >0){
                    for(i in results){
                        var status='';
                        if(results[i].status==0){
                           status="Pending";
                        }else if(results[i].status==1){
                           status="Aproved";
                        }else{status="Canceled";}
                        shtml +=`<tr>
                        <td class="text-center">${results[i].sale_num}</td>
                        <td class="text-center">${results[i].description}</td>
                        <td class="text-center">${results[i].in_date}</td>
                        <td class="text-center">${results[i].de_date}</td>
                        <td class="text-center">${results[i].sale_price}</td>
                        <td class="text-center">${results[i].spiff}</td>
                        <td class="text-center">${status}</td>
                        </tr>`;
                    }
                    $('#invdetail').html(shtml);
                }
            }
        });
    });

    
    $('#mdnum').keyup(function(){
        var mdnum = $('#mdnum').val();
        var shtml='';
        $('#skulist').html(shtml);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('getproduts') }}",
            type: "POST",
            data: { modelnum : mdnum},
            dataType: "json",
            success: function(result){
                const { results } = result;
                if(results.length >0){
                    for(i in results){
                        $('.restb').css({"display":"block"});
                        shtml +=`<tr id="trid_${results[i].sku}" sku="${results[i].sku}" category="${results[i].category}" description='${results[i].description}' subcatergory="${results[i].subcatergory}" series="${results[i].series}" colour="${results[i].colour}" msrp="${results[i].msrp}" msp="${results[i].msp}" spiff="${results[i].spiff}"><td class="text-start">${results[i].sku}</td></tr>`;
                    }
                    $('#skulist').html(shtml);
                    console.log("Ready");
                    $('#skulist tr').click(function(){
                        var mdlnm =$(this).attr('sku');
                        var description=$(this).attr('description');
                        var spiff = $(this).attr('spiff');
                        $('#mdnum').val(mdlnm);
                        $('#prodes').val(description);
                        $('#spiff').val(spiff);
                        $('.restb').css({"display":"none"});
                    })

                }
            }
        });
    });

    $('#add_salepro').click(function (){
        var memberid = $('#memberuth').val();
        var oid = $('#mdnum').val();
        var description = $('#prodes').val();
        var series = $("#series").val();
        var spiff = $('#spiff').val();
        var sale_num = $('#snum').val();
        var in_num = $('#innum').val();
        var in_date = $('#indate').val();
        var de_date = $('#dedate').val();
        var sale_price = $('#saleprice').val();
        typeof(sale_price);

        if(in_num===null||in_num==='', in_date ===null ||in_date==='', de_date===null||de_date==='', series===null||series==='', description===null||description==='', sale_num===''||sale_num===null ){
            alert("Please fill all fields");}
        else{
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('addproduct') }}",
                type: "POST",
                data: { memberid:memberid, model: oid, description: description, spiff:spiff, series: series, sale_num : sale_num, in_num: in_num, in_date : in_date, de_date: de_date, sale_price: sale_price },
                dataType: "json",
                success: function(result){
                    const { results } = result;
                    var shtml='';
                    if(results.length > 0){
                        for(i in results){
                            var key = Number(i)+1;
                            shtml +=`<tr>
                                        <td class="text-center">${ key }</td>
                                        <td class="text-center">${ results[i].model_num }</td>
                                        <td class="text-center">${ results[i].description }</td>
                                        <td class="text-center">${ results[i].spiff }</td>
                                        <td class="text-center">${ results[i].sale_price }</td>
                                        <td class="text-center">${ results[i].series }</td>
                                    </tr>`;
                        }
                        $('#protbl').html(shtml);
                        $('#mdnum').val('');
                        $('#prodes').val('');
                        $('#spiff').val('');
                    }
                    $("#series").val('');
                    $('#dedate').val('');
                    $('#saleprice').val('');
                },
            });
        }

    });

</script>

@endsection
