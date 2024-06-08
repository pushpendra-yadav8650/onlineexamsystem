@extends('layout/admin-layout')

@section('space-work')

<h2 class="mb-4">Examination</h2>
        <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addexamModel">
  Add Exam
</button>
<table class="table dark">
    <thead>
        <tr>
            <th>#</th>
            <th>Exam Name</th>
            <th>Subject</th>
            <th>Date</th>
            <th>Time</th>
            <th>attempt</th>
            <th>Edit</th>
            <th>Delte</th>
        </tr>
    </thead>
        <tbody>
           @if( count($exams)>0)
 
                @foreach($exams as $exam)
                    <tr>
                        <td>{{ $exam->id }}</td>
                        <td>{{ $exam->exam_name }}</td>
                        <td>{{ $exam->subjects }}</td>
                        <td>{{ $exam->date }}</td>
                        <td>{{ $exam->time }} Hrs</td>
                        <td>{{ $exam->attempt }} </td>
                        <td>
                            <button class="btn btn-info editButton" data-id="{{ $exam->id }}" data-toggle="modal" data-target="#editExamModel">Edit</button>
                        </td>
                        <td>
                            <button class="btn btn-danger deleteButton" data-id="{{ $exam->id }}" data-toggle="modal" data-target="#deleteExamModal">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @else
               <tr>
                <td colspan="5">Exam not Found</td>
               </tr>
           @endif
        </tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="addexamModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Exam Deatils</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addExam">
        @csrf
            <div class="modal-body">
                <label></label>
                <input type="text" name="exam_name" placeholder="Enter Exam name"  class="w-100" required><br><br>
                <select name="subject_id" required class="w-100">
                    <option>Select Subject</option>
                    @if(count($subjects)>0)
                    @foreach ( $subjects as $subject )
                        <option value="{{$subject->id}}">{{$subject->subject}}</option>
                    @endforeach
                    @endif
                </select><br><br>
                <input type="date" name="date" class="w-100" required min="@php echo date('Y-m-d'); @endphp"> <br><br>
                <input type="time" name="time" class="w-100" required><br><br>
                <input type="number" min="1" name="attempt" placeholder="Enter Exam Attempt time " class="w-100" required><br><br>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Exam</button>
            </div>
            </div>
        </form>
    </div>
    </div>
    <!-- Edit  -->
    <div class="modal fade" id="editExamModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Exam Deatils</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editExam">
        @csrf
            <div class="modal-body">
                <label></label>
                <input type="hidden" name="exam_id" id="exam_id">
                <input type="text" name="exam_name " id="exam_name" placeholder="Enter Exam name"  class="w-100" required><br><br>
                <select name="subject_id" id="subject_id" required class="w-100">
                    <option>Select Subject</option>
                    @if(count($subjects)>0)
                    @foreach ( $subjects as $subject )
                        <option value="{{$subject->id}}">{{$subject->subject}}</option>
                    @endforeach
                    @endif
                </select><br><br>
                <input type="date" name="date" id="date" class="w-100" required min="@php echo date('Y-m-d'); @endphp"> <br><br>
                <input type="time" name="time" id="time" class="w-100"required><br><br>
                <input type="number" min="1" id="attempt" name="attempt" placeholder="Enter Exam Attempt time " class="w-100" required><br><br>
               
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">update Exam</button>
            </div>
            </div>
        </form>
    </div>
    </div>
    <!-- Delete the model -->
<div class="modal fade" id="deleteExamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteExamModal">Exam Deatils</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteExam">
        @csrf
            <div class="modal-body">
                
                <input type="hidden" name="exam_id" id="deleteExamId">   
                <p class="text-danger text-center">Are you sure want to seltel Exam ?</p>         
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
            </div>
        </form>
    </div>
    </div>
<script>
    $(document).ready(function(){
        $("#addExam").submit(function(e){
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url:"{{ route('addExam') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    if(data.success == true){
                        location.reload();
                    }else{
                        alert(data.msg);
                    }
                }
            });
        });
    });
        $(".editButton").click(function(){
            var id= $(this).attr('data-id');

            $("#exam_id").val(id);

            var url = '{{ route("getExamDetail","id")}}';
            url = url.replace("id",id);

            $.ajax({
                url:url,
                type:'GET',
                success:function(data){
                    if(data.success == true){
                        var exam = data.data;
                        $("#exam_name").val(exam[0].exam_name);
                        $("#subject_id").val(exam[0].subject_id);
                        $("#date").val(exam[0].date);
                        $("#time").val(exam[0].time);
                        $("#attempt").val(exam[0].attempt);
                        $
                    }else{
                        alert(data.msg);
                    }
                }

            });
        });
       
        $("#editExam").submit(function(e){
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url:"{{ route('updateExam') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    if(data.success == true){
                        location.reload();
                    }else{
                        alert(data.msg);
                    }
                }
            });
        });
        //delte Exam

        $(".deleteButton").click(function(){
            var id = $(this).attr('data-id');
            $('#deleteExamId').val(id);
        });
        $("#deleteExam").submit(function(e){
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url:"{{ route('deleteExam') }}",
                type:"POST",
                data:formData,
                success:function(data){
                    if(data.success == true){
                        location.reload();
                    }else{
                        alert(data.msg);
                    }
                }
            });
    });
</script>
@endsection