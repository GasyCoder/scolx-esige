<?php
class StudentExam extends Mailable
{
    use Queueable, SerializesModels;
  
    public $student;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EtPresent $student)
    {
        $this->student = $student;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $notes = Note::join('elements', 'elements.id', '=', 'notes.element_id')
                      ->join('students', 'students.id', '=', 'notes.id_student')
                      ->join('niveau', 'niveau.id', '=', 'notes.class_id')
                      ->select('elements.id as elem_id', 
                        'elements.element', 
                        'notes.note')->where('students.id' $this->student->id)->get();

        return $this->from('gasycoder@gasycoder.com')
                    ->subject('Mail from gasycoder')
                    ->view('emails.contact')
                    ->with(['student'=>$this->student, 'exams'=>$notes]);
    }
}