<!DOCTYPE html>
<html>
<head>
	<title>PERFORMANCE APPRAISAL</title>
	<link href="{{ public_path('/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
	<style type="text/css">
		p {
            margin-top: 2.5px;
            margin-bottom: 2.5px;
        }
        .table thead tr th {
            vertical-align: middle;
            font-size: 14px;
            padding-top: 8px;
            padding-bottom: 8px;
        }
        .table tbody tr td {
            font-size: 13px;
            padding-top: 8px;
            padding-bottom: 8px;
        }
        .table-view thead tr th, .table-view tbody tr td {
            padding: .25rem;
            font-size: 14px;
        }
        .table-view thead tr th {
            background-color: #EFEFEF;
        }
        .table-view tbody tr td div {
            min-height: 165px;
        }
        table { page-break-inside: auto; border-collapse: collapse; }
        thead { display: table-row-group; }
        tfoot { display: table-row-group; }
        tr { page-break-inside: auto !important; }
        @media print {
            table { page-break-inside: auto; border-collapse: collapse; }
            thead { display: table-row-group; }
            tfoot { display: table-row-group; }
            tr { page-break-inside: auto !important; }
            .table-view {
                overflow : visible !important;
            }
        }
	</style>
</head>
<body style="padding-left: 2.5rem; padding-right: 2.5rem;">

	<div class="row mb-3">
        <div class="col-md-9">
            <div class="row mb-1">
                <div class="col-md-3">NIK Karyawan</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8">{{ $appraisal->appraisal_user_nik }}</div>
            </div>
            <div class="row mb-1">
                <div class="col-md-3">Nama Karyawan</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8">{{ $appraisal->appraisal_user_name }}</div>
            </div>
            <div class="row mb-1">
                <div class="col-md-3">Departemen</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8">{{ $appraisal->department_name }}</div>
            </div>
            <div class="row">
                <div class="col-md-3">Level</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8">Staff</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="w-100 text-center">
                <h4 class="font-weight-bold">{{ $period->period_name }}</h4>
                <h4 class="font-weight-bold">{{ $appraisal->appraisal_status }}</h4>
            </div>
        </div>
    </div>

    <p class="font-weight-bold" style="font-size: 18px;"> BAGIAN I : KPI/OBJECTIVE <p>
    <p class="font-weight-bold" style="font-size: 13px;">Petunjuk Penilaian Objective :</p>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 3%; font-size: 13px;"><b>I.</b></td>
                <td style="font-size: 13px;"><b>Objective / Area Kerja</b> - Diisi oleh karyawan yang bersangkutan berdasarkan area kerja utama / uraian kerja utama.</td>
            </tr>
            <tr>
                <td style="width: 3%; font-size: 13px;"><b>II.</b></td>
                <td style="font-size: 13px;"><b>Penilaian karyawan mengenai pencapaian Objective / Area Kerja</b> - Diisi dengan hasil kerja yang dapat terukur (Kualitatif / Kuantitatif).</td>
            </tr>
            <tr>
                <td style="width: 3%; font-size: 13px; vertical-align: top;"><b>III.</b></td>
                <td style="font-size: 13px;"><b>Penilaian atasan mengenai pencapaian Objective / Area Kerja</b> - Diisi dengan feedback konstruktif atas observasi hasil dari penilaian karyawan dan dinilai dengan acuan seperti dibawah :</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-sm table-bordered mt-2">
        <tbody>
            <tr>
                <td style="width: 20%; font-size: 12px;">1 - Outstanding / Outperform</td>
                <td style="width: 20%; font-size: 12px;">2 - Exceed Expectation</td>
                <td style="width: 20%; font-size: 12px;">3 - Meet Expectation</td>
                <td style="width: 20%; font-size: 12px;">4 - Below Expectation</td>
                <td style="width: 20%; font-size: 12px;">5 - Did not Meet Expectation</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="text-align: center; width: 50px;"> No </th>
                <th> Objective / Area Kerja </th>
                <th> Penilaian Karyawan Mengenai<br>Pencapaian Objective / Area Kerja </th>
                <th> Penilaian Atasan Mengenai<br>Pencapaian Objective / Area Kerja </th>
                <th style="text-align: center;"> Nilai </th>
            </tr>
        </thead>
        <tbody>
            @foreach($objective as $key => $o)
                <tr>
                    <td style="text-align: center; vertical-align: middle;">{{ $key+1 }}</td>
                    <td><?php echo str_replace("\n", "<br>", htmlentities($o->objective_description)); ?></td>
                    <td><?php echo str_replace("\n", "<br>", htmlentities($o->employee_assessment)); ?></td>
                    <td><?php echo str_replace("\n", "<br>", htmlentities($o->superior_assessment)); ?></td>
                    <td style="text-align: center; vertical-align: middle;">{{ $o->superior_score }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h6 class="font-weight-bold">Komentar Keseluruhan terhadap Objective</h6>
    <table class="table table-bordered">
        <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->objective_comment)); ?></td>
    </table>
    <table class="table table-striped table-bordered">
        <td class="font-weight-bold" style="width: 85%;">NILAI OBJECTIVE KESELURUHAN</td>
        <td class="font-weight-bold text-center">{{ $appraisal->overall_objective_score }}</td>
    </table>

    <p class="font-weight-bold" style="font-size: 18px;"> BAGIAN II : KOMPETENSI </p>
    <p class="font-weight-bold" style="font-size: 13px;">Petunjuk Penilaian Kompetensi :</p>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 3%; font-size: 13px;"><b>I.</b></td>
                <td style="font-size: 13px;">Penilaian kompetensi oleh diri sendiri diisi dengan mengacu pada 4 level kemahiran pada pilihan yang telah disediakan.</td>
            </tr>
            <tr>
                <td style="width: 3%; font-size: 13px;"><b>II.</b></td>
                <td style="font-size: 13px;">Level kemahiran disusun berdasarkan kategori Basic (pilihan pertama) dan Expert (pilihan terakhir).</td>
            </tr>
            <tr>
                <td style="width: 3%; font-size: 13px;"><b>III.</b></td>
                <td style="font-size: 13px;">Penilaian dilakukan dengan melihat kesesuaian kemampuan/keahlian Anda dalam menyelesaikan pekerjaan.</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th style="text-align: center; width: 50px;"> No </th>
                <th style="width: 35%;"> Kompetensi </th>
                <th style="width: 30%;"> Penilaian Tingkat Kemahiran<br>dari Karyawan </th>
                <th> Penilaian Tingkat Kemahiran<br>dari Atasan </th>
            </tr>
        </thead>
        <tbody>
        	@foreach($competency as $key => $com)
        		<tr>
        			<td style="text-align: center; vertical-align: middle;">{{ $key+1 }}</td>
        			<td><?php echo "<b>".$com['competency_title_eng']."</b><br>".str_replace("\n", "<br>", htmlentities($com['competency_bhs'])); ?></td>
                    <td><?php echo str_replace("\n", "<br>", htmlentities($com['proficiency_'.$com['employee_rating'].'_bhs'])); ?></td>
                    <td><?php echo str_replace("\n", "<br>", htmlentities($com['proficiency_'.$com['superior_rating'].'_bhs'])); ?></td>
        		</tr>
        	@endforeach
        </tbody>
    </table>
    <h6 class="font-weight-bold">Komentar Keseluruhan terhadap Kompetensi</h6>
    <table class="table table-bordered">
        <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->competency_comment)); ?></td>
    </table>
    <p class="font-weight-bold mt-0 mb-1" style="font-size: 14px;">Petunjuk Penilaian Kompetensi Keseluruhan</p>
    <p style="font-size: 13px;">Penilaian kompetensi secara keseluruhan, diisi oleh atasan mengacu kepada definisi rating (1-5).</p>
    <table class="table table-sm table-bordered mt-2">
        <tbody>
            <tr>
                <td style="width: 20%; font-size: 12px;">1 - Outstanding / Outperform</td>
                <td style="width: 20%; font-size: 12px;">2 - Exceed Expectation</td>
                <td style="width: 20%; font-size: 12px;">3 - Meet Expectation</td>
                <td style="width: 20%; font-size: 12px;">4 - Below Expectation</td>
                <td style="width: 20%; font-size: 12px;">5 - Did not Meet Expectation</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-striped table-bordered">
        <td class="font-weight-bold" style="width: 85%;">NILAI KOMPETENSI KESELURUHAN</td>
        <td class="font-weight-bold text-center">{{ $appraisal->overall_competency_score }}</td>
    </table>

    <p class="font-weight-bold" style="font-size: 18px;"> BAGIAN III : KPI/OBJECTIVE UNTUK TAHUN DEPAN </p>
    <p class="font-weight-bold" style="font-size: 13px;">Petunjuk Pengisian Objective / KPI Tahun Depan :</p>
    <p style="font-size: 13px;">Diisi oleh karyawan yang bersangkutan berdasarkan area kerja utama / uraian kerja utama yang akan dilakukan / target untuk tahun depan.</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="text-align: center; width: 50px;"> No </th>
                <th> KPI / Objective </th>
            </tr>
        </thead>
        <tbody>
            @foreach($objective_next as $key => $o)
                <tr>
                    <td style="text-align: center; vertical-align: middle;">{{ $key+1 }}</td>
                    <td><?php echo str_replace("\n", "<br>", htmlentities($o->objective_next_description)); ?></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="font-weight-bold" style="font-size: 18px;"> BAGIAN IV : PENGEMBANGAN DIRI </p>
    <h6 class="font-weight-bold mb-0">Kebutuhan Pengembangan Keahlian/Keterampilan bagi Karyawan</h6>
    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th style="width: 50%;"> Dari Karyawan </th>
                <th style="width: 50%;"> Dari Atasan </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->training_employee)); ?></td>
                <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->training_superior)); ?></td>
            </tr>
        </tbody>
    </table>
    <h6 class="font-weight-bold mb-0">Pengembangan Karir Karyawan</h6>
    <table class="table table-bordered mt-2">
        <thead>
            <tr>
                <th style="width: 50%;"> Dari Karyawan </th>
                <th style="width: 50%;"> Dari Atasan </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->career_development_employee)); ?></td>
                <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->career_development_superior)); ?></td>
            </tr>
        </tbody>
    </table>

    <p class="font-weight-bold" style="font-size: 18px;"> BAGIAN V : ULASAN KINERJA </p>
    <h6 class="font-weight-bold">Kesimpulan Penilaian Kinerja</h6>
    <table class="table table-bordered">
        <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->appraisal_summary)); ?></td>
    </table>

    <table class="table table-striped table-bordered mb-0">
        <td class="font-weight-bold" style="width: 85%;">NILAI OBJECTIVE KESELURUHAN</td>
        <td class="font-weight-bold text-center">{{ $appraisal->overall_objective_score }}</td>
    </table>
    <table class="table table-striped table-bordered mb-0">
        <td class="font-weight-bold" style="width: 85%;">NILAI KOMPETENSI KESELURUHAN</td>
        <td class="font-weight-bold text-center">{{ $appraisal->overall_competency_score }}</td>
    </table>
    <table class="table table-striped table-bordered">
        <td class="font-weight-bold" style="width: 85%;">NILAI KESELURUHAN KINERJA</td>
        <td class="font-weight-bold text-center">{{ $appraisal->overall_performance_score }}</td>
    </table>

    <table class="table table-sm table-bordered mt-2">
        <tbody>
            <tr>
                <td style="width: 20%; font-size: 12px; vertical-align: middle;"><b>OSC</b> : Outstanding Contribution</td>
                <td style="width: 20%; font-size: 12px; vertical-align: middle;"><b>ECC</b> : Excellent Contribution</td>
                <td style="width: 20%; font-size: 12px; vertical-align: middle;"><b>HVC</b> : Highly Valued Contribution</td>
                <td style="width: 20%; font-size: 12px; vertical-align: middle;"><b>MCE</b> : More Contribution Expected</td>
                <td style="width: 20%; font-size: 12px; vertical-align: middle;"><b>USC</b> : Unsatisfactory Contribution</td>
            </tr>
        </tbody>
    </table>

    @if($appraisal->employee_feedback != null)
        <h6 class="font-weight-bold mb-0">Feedback dari Karyawan</h6>
        <table class="table table-bordered mt-2">
            <td><?php echo str_replace("\n", "<br>", htmlentities($appraisal->employee_feedback)); ?></td>
        </table>
    @endif

    <div class="row mb-3">
    	<div class="col-md-3">
    		<table class="table table-bordered table-view" style="width: 100%;">
    			<thead>
    				<tr>
    					<th style="text-align: center;"> PROPOSED BY </th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr>
    					<td class="text-center">
                            <div>
        						<span>{{ $appraisal->appraisal_user_title }}</span><br>
        						<img src="{{ public_path('/images/approved.png') }}" style="max-height: 100%; max-width: 75%;"><br>
        						<span>{{ $appraisal->appraisal_user_name }}</span><br>
        						<span>{{ $appraisal->appraisal_user_nik }}</span><br>
        						<span>{{ date_format(date_create($appraisal->created_at), "d M Y") }}</span>
                            </div>
    					</td>
    				</tr>
    			</tbody>
    		</table>
    	</div>
    	<div class="col-md-6">
    		<table class="table table-bordered table-view" style="width: 100%;">
    			<thead>
    				<tr>
    					<th colspan="3" style="text-align: center;"> APPROVED BY </th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr>
    					<td class="text-center" style="width: 50%;">
                            <div>
        						@if($appraisal->appraisal_approval_status_1 != null)
        							<span>{{ $appraisal->appraisal_approval_title_1 }}</span><br>
        							<img src="{{ public_path('/images/approved.png') }}" style="max-height: 100%; max-width: 75%;"><br>
        							<span>{{ $appraisal->appraisal_approval_name_1 }}</span><br>
        							<span>{{ $appraisal->appraisal_approval_nik_1 }}</span><br>
        							<span>{{ date_format(date_create($appraisal->appraisal_approval_date_1), "d M Y") }}</span>
        						@endif
                            </div>
    					</td>
    					<td class="text-center" style="width: 50%;">
                            <div>
        						@if($appraisal->appraisal_approval_status_2 != null)
        							<span>{{ $appraisal->appraisal_approval_title_2 }}</span><br>
        							<img src="{{ public_path('/images/approved.png') }}" style="max-height: 100%; max-width: 75%;"><br>
        							<span>{{ $appraisal->appraisal_approval_name_2 }}</span><br>
        							<span>{{ $appraisal->appraisal_approval_nik_2 }}</span><br>
        							<span>{{ date_format(date_create($appraisal->appraisal_approval_date_2), "d M Y") }}</span>
        						@endif
                            </div>
    					</td>
    				</tr>
    			</tbody>
    		</table>
    	</div>
        <div class="col-md-3">
    		<table class="table table-bordered table-view" style="width: 100%;">
    			<thead>
    				<tr>
    					<th style="text-align: center;"> REVIEWED BY HR </th>
    				</tr>
    			</thead>
    			<tbody>
    				<tr>
    					<td class="text-center">
                            <div>
        						<span>{{ $appraisal->appraisal_approval_title_hr }}</span><br>
        						<img src="{{ public_path('/images/approved.png') }}" style="max-height: 100%; max-width: 75%;"><br>
        						<span>{{ $appraisal->appraisal_approval_name_hr }}</span><br>
        						<span>{{ $appraisal->appraisal_approval_nik_hr }}</span><br>
        						<span>{{ date_format(date_create($appraisal->appraisal_approval_date_hr), "d M Y") }}</span>
                            </div>
    					</td>
    				</tr>
    			</tbody>
    		</table>
    	</div>
    </div>

</body>
</html>