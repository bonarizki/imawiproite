<div class="modal fade" id="modal-feedback" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Training Feedback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form">
                    @csrf
                    <input type="text" id="training_participant_id" name="training_participant_id" hidden>
                    <div class="col-12">
                        <div class="form-group" id="training_feedback_1_group">
                            <label>
                                1. Metode Training <span class="text-danger">*</span>
                            </label>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_1" value="In House Training ( Jika training dilakukan di lingkungan kantor)">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    In House Training ( Jika training dilakukan di lingkungan kantor)
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_1" value="External Training (Jika training dilakukan di luar lingkungan kantor)">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    External Training (Jika training dilakukan di luar lingkungan kantor)
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_1" value="Webinar Training (Training Online)">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Webinar Training (Training Online)
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_1" value="Others">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Others
                                </span>
                            </div>
                        </div>
                        <div class="form-group" id="training_feedback_2_group">
                            <label>
                                2.  Insuktur Training ( jika instruktur dari luar Wipro, mohon untuk menuliskan nama PT dari penyelenggara training tersebut ) :
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="training_feedback_2" class="form-control" name="training_feedback_2" placeholder="your answer">
                        </div>
                        <div class="form-group" id="training_feedback_3_group">
                            <label>
                                3. Bermanfaatkah materi yang telah disampaikan terhadap pelaksanaan dan fungsi kerja Anda?  
                                <span class="text-danger">*</span>
                            </label>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_3" value="Sangat Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_3" value="Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_3" value="Cukup">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Cukup
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_3" value="Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Kurang
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_3" value="Sangat Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Kurang
                                </span>
                            </div>
                        </div>
                        <div class="form-group" id="training_feedback_4_group">
                            <label>
                                4.Sesuaikah materi yang telah disampaikan terhadap perkembangan (trend) dewasa ini?
                                <span class="text-danger">*</span>
                            </label>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_4" value="Sangat Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_4" value="Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_4" value="Cukup">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Cukup
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_4" value="Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Kurang
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_4" value="Sangat Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Kurang
                                </span>
                            </div>
                        </div>
                        <div class="form-group" id="training_feedback_5_group">
                            <label>
                                5.Menarikkah bahan materi sehingga dapat membantu Anda dalam memahami topik training? 
                                <span class="text-danger">*</span>
                            </label>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_5" value="Sangat Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_5" value="Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_5" value="Cukup">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Cukup
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_5" value="Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Kurang
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_5" value="Sangat Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Kurang
                                </span>
                            </div>
                        </div>
                        <div class="form-group" id="training_feedback_6_group">
                            <label>
                                6. Sesuaikah topik materi terhadap isi pembicaraan / diskusi / informasi yang telah disampaikan? 
                                <span class="text-danger">*</span>
                            </label>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_6" value="Sangat Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_6" value="Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_6" value="Cukup">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Cukup
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_6" value="Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Kurang
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_6" value="Sangat Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Kurang
                                </span>
                            </div>
                        </div>
                        <div class="form-group" id="training_feedback_7_group">
                            <label>
                                7. Efektifkah metode training yang dibawakan instruktur dalam menerjemahkan materi?  
                                <span class="text-danger">*</span>
                            </label>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_7" value="Sangat Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_7" value="Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_7" value="Cukup">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Cukup
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_7" value="Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Kurang
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_7" value="Sangat Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Kurang
                                </span>
                            </div>
                        </div>
                        <div class="form-group" id="training_feedback_8_group">
                            <label>
                                8. Menarikkah instruktur dalam menyampaikan materi? 
                                <span class="text-danger">*</span>
                            </label>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_8" value="Sangat Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_8" value="Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_8" value="Cukup">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Cukup
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_8" value="Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Kurang
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_8" value="Sangat Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Kurang
                                </span>
                            </div>
                        </div>
                        <div class="form-group" id="training_feedback_9_group">
                            <label>
                                9. Mampukah instruktur menanggapi pertanyaan yang diajukan peserta? 
                                <span class="text-danger">*</span>
                            </label>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_9" value="Sangat Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_9" value="Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_9" value="Cukup">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Cukup
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_9" value="Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Kurang
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_9" value="Sangat Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Kurang
                                </span>
                            </div>
                        </div>
                        <div class="form-group" id="training_feedback_10_group">
                            <label>
                                10. Secara teori apakah instruktur menguasai materi yang dibawakan? 
                                <span class="text-danger">*</span>
                            </label>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_10" value="Sangat Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_10" value="Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_10" value="Cukup">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Cukup
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_10" value="Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Kurang
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_10" value="Sangat Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Kurang
                                </span>
                            </div>
                        </div>
                        <div class="form-group" id="training_feedback_11_group">
                            <label>
                                11. Komunikatifkah Instruktur terhadap peserta secara umum dalam membawa presentasi? 
                                <span class="text-danger">*</span>
                            </label>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_11" value="Sangat Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_11" value="Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_11" value="Cukup">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Cukup
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_11" value="Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Kurang
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_11" value="Sangat Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Kurang
                                </span>
                            </div>
                        </div>
                        <div class="form-group" id="training_feedback_12_group">
                            <label>
                                12. Menarikkah metode pengajaran yang diberikan dalam training ini? 
                                <span class="text-danger">*</span>
                            </label>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_12" value="Sangat Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_12" value="Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_12" value="Cukup">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Cukup
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_12" value="Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Kurang
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_12" value="Sangat Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Kurang
                                </span>
                            </div>
                        </div>
                        <div class="form-group" id="training_feedback_13_group">
                            <label>
                                13. MApakah instruktur secara umum menguasai "medan" (peserta, kelas maupun pengaturan waktu)? 
                                <span class="text-danger">*</span>
                            </label>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_13" value="Sangat Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_13" value="Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_13" value="Cukup">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Cukup
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_13" value="Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Kurang
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_13" value="Sangat Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Kurang
                                </span>
                            </div>
                        </div>
                        <div class="form-group" id="training_feedback_14_group">
                            <label>
                                14. Apakah jumlah peserta yang diikutkan, dapat memberikan kenyamanan dalam training tersebut? 
                                <span class="text-danger">*</span>
                            </label>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_14" value="Sangat Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_14" value="Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_14" value="Cukup">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Cukup
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_14" value="Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Kurang
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_14" value="Sangat Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Kurang
                                </span>
                            </div>
                        </div>
                        <div class="form-group" id="training_feedback_15_group">
                            <label>
                                15. Apakah fasilitas yang disediakan dalam training tersebut memadai? (Soundsystem, Modul, dll) 
                                <span class="text-danger">*</span>
                            </label>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_15" value="Sangat Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_15" value="Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_15" value="Cukup">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Cukup
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_15" value="Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Kurang
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_15" value="Sangat Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Kurang
                                </span>
                            </div>
                        </div>
                        <div class="form-group" id="training_feedback_16_group">
                            <label>
                                16. Apakah Anda di dalam mengikuti training tersebut, dapat berkonsentrasi pada materi ? 
                                <span class="text-danger">*</span>
                            </label>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_16" value="Sangat Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_16" value="Baik">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Baik
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_16" value="Cukup">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Cukup
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_16" value="Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Kurang
                                </span>
                            </div>
                            <div class="vs-radio-con vs-radio-primary">
                                <input type="radio" name="training_feedback_16" value="Sangat Kurang">
                                <span class="vs-radio vs-radio-lg">
                                    <span class="vs-radio--border"></span>
                                    <span class="vs-radio--circle"></span>
                                </span>
                                <span class="">
                                    Sangat Kurang
                                </span>
                            </div>
                        </div>
                        <div class="form-group" id="training_feedback_17_group">
                            <label>
                                17.  Saran dan masukan terkait dengan training ini, dan training di akan mendatang : 
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="training_feedback_17" class="form-control" name="training_feedback_17" placeholder="your answer">
                        </div>
                        <div class="form-group" id="training_feedback_18_group">
                            <label>
                                18. Level kepuasan anda terhadap pelaksanan training ? 
                                <span class="text-danger">*</span>
                            </label>
                            <ul class="list-unstyled mb-0" style="padding-left: 30px">
                                <li class="d-inline-block mr-2">
                                    Tidak Puas
                                </li>
                                <li class="d-inline-block mr-2 ">
                                    <fieldset>
                                        <div class="vs-radio-con vs-radio-primary">
                                            <input type="radio" name="training_feedback_18" value="1">
                                            <span class="vs-radio vs-radio-lg">
                                                <span class="vs-radio--border"></span>
                                                <span class="vs-radio--circle"></span>
                                            </span>
                                            <span class="">1</span>
                                        </div>
                                    </fieldset>
                                </li>
                                <li class="d-inline-block mr-2">
                                    <fieldset>
                                        <div class="vs-radio-con vs-radio-primary">
                                            <input type="radio" name="training_feedback_18" value="2">
                                            <span class="vs-radio vs-radio-lg">
                                                <span class="vs-radio--border"></span>
                                                <span class="vs-radio--circle"></span>
                                            </span>
                                            <span class="">2</span>
                                        </div>
                                    </fieldset>
                                </li>
                                <li class="d-inline-block mr-2">
                                    <fieldset>
                                        <div class="vs-radio-con vs-radio-primary">
                                            <input type="radio" name="training_feedback_18" value="3">
                                            <span class="vs-radio vs-radio-lg">
                                                <span class="vs-radio--border"></span>
                                                <span class="vs-radio--circle"></span>
                                            </span>
                                            <span class="">3</span>
                                        </div>
                                    </fieldset>
                                </li>
                                <li class="d-inline-block mr-2">
                                    <fieldset>
                                        <div class="vs-radio-con vs-radio-primary">
                                            <input type="radio" name="training_feedback_18" value="4">
                                            <span class="vs-radio vs-radio-lg">
                                                <span class="vs-radio--border"></span>
                                                <span class="vs-radio--circle"></span>
                                            </span>
                                            <span class="">4</span>
                                        </div>
                                    </fieldset>
                                </li>
                                <li class="d-inline-block mr-2">
                                    <fieldset>
                                        <div class="vs-radio-con vs-radio-primary">
                                            <input type="radio" name="training_feedback_18" value="5">
                                            <span class="vs-radio vs-radio-lg">
                                                <span class="vs-radio--border"></span>
                                                <span class="vs-radio--circle"></span>
                                            </span>
                                            <span class="">5</span>
                                        </div>
                                    </fieldset>
                                </li>
                                <li class="d-inline-block mr-2">
                                    Sangat Puas
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="validasi()">Save changes</button>
            </div>
        </div>
    </div>
</div>