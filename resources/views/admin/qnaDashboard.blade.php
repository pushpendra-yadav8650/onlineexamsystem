@extends('layout/admin-layout')

@section('space-work')

<h2 class="mb-4">Q&A</h2>

<button type="button " class="btn btn-primary" data-toggle="modal" data-target="#AddQnaModal">
    Add Q&A
</button>
<table class="table">
    <thead>
        <th>#</th>
        <th>Question</th>
        <th>Answers</th>
        <th>Edit</th>
    </thead>
    <tbody>
         @if(count($questions) )
            @foreach($questions as $question)
            <tr>
                <td>{{ $question->id }}</td>
                <td>{{ $question->question }}</td>
                <td>
                    <a href="#" class="ansButton" data-id="{{ $question->id }}" data-toggle="modal" data-target="#showAnsModal"> See Answer</a>
                </td>
                <td>
                    <button class="btn btn-info editButton" data-id="{{ $question->id }}" data-toggle="modal" data-target="#editQnaModal">Edit</button>
                </td>
                </tr>
            @endforeach
         @else
                <tr>
                    <td clospan="3">Questions and Answer is not found</td>
                </tr>
         @endif
    </tbody>
</table>

<!--add exam Modal -->
<div class="modal fade" id="AddQnaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Question adn Answer</h5>
                <button id="addAnswer" class="btn btn-info ml-5">Add answwer &nbsp;</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addQna">
                @csrf
            <div class="modal-body addModalAnswer">
            <div class="row ">
                <div class="col">
                    <input type="text" class="w-100" name="question " placeholder="Enter Question" required>
                </div> 
            </div>
            <div class="modal-footer">
                <span class="error" style="color:red;"></span>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add Q&A</button>
            </div>
            </div>
       </form>
    </div>
    </div>
</div>
<!-- show Answer this modal -->
<div class="modal fade" id="showAnsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Show Answers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Answer</th>
                        <th>Is Correct</th>
                    </thead>
                    <tbody class="showAnswers">
                    
                    </tbody>
                </table>
            <div class="modal-footer">
                <span class="error" style="color:red;"></span>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
       
    </div>
    </div>
</div>
<!-- Edit Question and  Answer this modal -->
<div class="modal fade" id="editQnaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Question and  Answers</h5>
                <button id="addEditAnswers" class="ml-5 btn btn-info">Add answer</button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                
            </div>
            <form id="editQna">
                @csrf
            <div class="modal-body editModalAnswers">
                <div class="row">
                    <div class="col">
                        <input type="hidden" name="question_id" id="question_id">
                        <input type="text" class="w-100" class="question" id="question" placeholder="" required>
                    </div>
                </div>
                
            <div class="modal-footer">
                <span class="editError" style="color:red;"></span>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update Q&A</button>
            </div>
            </div>
            </form>
       
    </div>
    </div>
</div>
    <script>
        $(document).ready(function(){
            $("#addQna").submit(function(e){
                e.preventDefault();
                if($(".answers").length < 2){
                    $(".error").text("please add minimum two answers")
                    setTimeout(function(){
                        $(".error").text(" ");
                    },2000);
                }else{
                    var checkIsCorrect = false;

                    for( let i = 0 ; i< $(".is_correct").length; i++){
                        if($(".is_correct:eq("+i+")").prop('checked')== true){
                            checkIsCorrect= true;
                            $(".is_correct:eq("+i+")").val($(".is_correct:eq("+i+")").next().find('input').val() );
                        }
                    }
                    if(checkIsCorrect){
                        var formData = $(this).serialize();
                        $.ajax({
                            url:"{{ route('addQna')}}",
                            type:"POST",
                            data:formData,
                            success:function(data){
                                console.log(data);
                                if(data.success == true){
                                    location.reload();
                                }else{
                                    alert(data.msg);
                                }
                            }
                        })
                    }else{
                        $(".error").text("please select any one  correct answer")
                    setTimeout(function(){
                        $(".error").text(" ");
                    },2000);
                    }

                }
            });
            //add asnwer
            $('#addAnswer').click(function(){
                if($(".answers").length >= 6){
                    $(".error").text("You can add Maximum 6 answer")
                    setTimeout(function(){
                        $(".error").text(" ");
                    },2000);
                }else{
                    var html = `
                <div  class="row mt-2  answers">
                    <input type="radio" name="is_correct" class="is_correct">
                    <div class="col">
                        <input type="text" class="w-100" name="answer[]" placeholder="Enter Answer" reqired>
                    </div>
                    <button class="btn btn-danger removeButton "> Remove</button>
                </div>
                `;
                $(".addModalAnswer").append(html);
                }
            });
//Remove the answer button 
            $(document).on("click",".removeButton",function(){
                $(this).parent().remove();
            });


            //Show answer COde

            $(".ansButton").click(function(){
                var questions = @json($questions);
                var qid = $(this).attr('data-id');
                var html = '';
                
                for(let i=0; i < questions.length; i++){
                    if(questions[i]['id'] == qid){
                        var answersLength = questions[i]['answers'].length;
                        for(let j=0; j<answersLength; j++){ 
                            let is_correct = 'No';
                            if(questions[i]['answers'][j]['is_correct'] == 1){
                                is_correct="Yes";
                            }
                            html += `
                            <tr>
                                <td>`+(j+1)+`</td>
                                <td>`+questions[i]['answers'][j]['answer']+`</td>
                                <td>`+is_correct+`</td>
                            </tr>
                            `;
                            
                        }
                      
                    }
                }
                $('.showAnswers').html(html);

            });
        });
    </script>
@endsection