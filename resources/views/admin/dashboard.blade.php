@extends('layout/admin-layout')

@section('space-work')
<div id="content" class="">
        <h2 class="mb-4">Subjects</h2>
        <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSubjectModel">
  Add subject
</button>
<!----table-------------->
<table class="table table-dark mt-3">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">subject</th>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
    @if (count($subjects)>0)
        @foreach ( $subjects as $subject )
        <tr>
            <td>{{ $subject->id}}</td>
            <td>{{ $subject->subject}}</td>
            <td>
                <button class="btn btn-info editButton" data-id="{{ $subject->id}}" data-subject="{{ $subject->subject}}" data-toggle="modal" data-target="#editSubjectModel">Edit</button>
            </td>
            <td>
                <button class="btn btn-danger deleteButton" data-id="{{ $subject->id}}" data-toggle="modal" data-target="#deleteSubjectModel">Delete</button>
            </td>
        </tr>
        @endforeach
    
     @else
       <tr>
        <td colspan="4">subject not found</td>
       </tr>
    @endif
  </tbody>
</table>
<!----table-------------->
<!-- Modal -->
    <div class="modal fade" id="addSubjectModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addSubject">
        @csrf
            <div class="modal-body">
                <label></label>
                <input type="text" name="subject" placeholder="Enter Subject name"  class="m-100" required>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
            </div>
        </form>
    </div>
    </div>
</div>

    <!-- Edit subject -->
    <div class="modal fade" id="editSubjectModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSubject">
        @csrf
            <div class="modal-body">
                <label>Subject name</label>
                <input type="text" name="subject" placeholder="Enter Subject name" id="edit_subject" class="form-control" required>
                <input type="hidden" name="id" id="edit_subject_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">update</button>
            </div>
            </div>
        </form>
    </div>
    </div>

<!--Edit data------>
<!--- Delete subject--------------------->
<div class="modal fade" id="deleteSubjectModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Subject</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="deleteSubject">
        @csrf
            <div class="modal-body">
                
                <p style="color:red">Are you sure you want to delete subject</p>
                <input type="hidden" name="id" id="delete_subject_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Delete</button>
            </div>
            </div>
        </form>
    </div>
    </div>
<!--- Delete subject--------------------->
<script>
    $(document).ready(function(){
        $("#addSubject").submit(function(e){
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url:"{{ route('addSubject')}}",
                type:"POST",
                data:formData,
                success:function(data){
                    if(data.success == true){
                        location.reload();
                    }else{
                        alert(data.msg)
                    }
                }
            });
        });
        //edit subject
        $(".editButton").click(function(){
            var subject_id = $(this).attr('data-id');
           var subject = $(this).attr('data-subject');
           $("#edit_subject").val(subject);
           $('#edit_subject_id').val(subject_id);
        });
        $("#editSubject").submit(function(e){
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url:"{{ route('editSubject')}}",
                type:"POST",
                data:formData,
                success:function(data){
                    if(data.success == true){
                        location.reload();
                    }else{
                        alert(data.msg)
                    }
                }
            });
        });

        //delete subject

        $(".deleteButton").click(function(){
            var subject_id = $(this).attr('data-id');
            $("#delete_subject_id").val(subject_id);
        });

        $("#deleteSubject").submit(function(e){
            e.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url:"{{ route('deleteSubject')}}",
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
</script>
@endsection