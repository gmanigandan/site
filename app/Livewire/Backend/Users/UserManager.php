<?php
namespace Victorybiz\LaravelTelInput;
namespace App\Livewire\Backend\Users;
use Livewire\Attributes\Validate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Backend\User;
use App\Models\Backend\Keyword;
use App\Models\Backend\UserKeyword;
use Livewire\Attributes\Layout;
#[Layout('components.layouts.admin-dashboard')] 
class UserManager extends Component
{
    public $id;
    
    public $recordRow;
    public $wireKey;
    public $name,$username,$email,$phone, $countryCode,$countryDialCode,$tropoUserPhoneNo,$phNoDueDate;
    public $password, $password_confirmation;
    public $inputs = [];
    public $i = 1;
    public $keywordTitle = []; 
    public $keywordIds = []; 
    public $deletedKeywordIds = []; 
    protected $messages = [
        'keywordTitle.*.required' => 'The keyword field is required.',
    ];
    public function mount(Request $request)
    {
        $this->wireKey = Str::random();
        $this->id = $request->route('id');
        if($request->route('id')){
            $this->checkRowIfExists();
        }
        $this->inputs[] = $this->i; 

    }
    public function addField()
    {
        $rules = [];
        foreach ($this->inputs as $key => $value) {
            $rules['keywordTitle.' . $key ] = 'required|string'; 
       
        }
        $this->validate( $rules);
 
        $this->i++;
        $this->inputs[] = $this->i;
    }

    public function removeField($index)
    {
        if (isset($this->keywordIds[$index])) {
            // Add the keyword ID to the list of deleted keyword IDs
            $this->deletedKeywordIds[] = $this->keywordIds[$index];
        }

        unset($this->inputs[$index]);
        unset($this->keywordTitle[$index]); 
        unset($this->keywordIds[$index]); 
        $this->inputs = array_values($this->inputs); 
        $this->keywordTitle = array_values($this->keywordTitle); 
    }

    public function checkRowIfExists()
    {
      
        $recordRow = User::with('keywords')->findOrFail($this->id);
        if ($recordRow) {
            //  dd($recordRow->toSql());
            // dd($recordRow->keywords);
            $this->keywordTitle = [];
            $this->inputs = [];
            $this->keywordIds = [];
            foreach ($recordRow->keywords as $key => $keyword) {
                $this->keywordTitle[] = $keyword->keywordTitle;
                $this->keywordIds[] = $keyword->id;
                $this->inputs[] = $key;
            }
            $this->recordRow = $recordRow;
            $this->fill($this->recordRow);
        }else{
            session()->flash('error', 'Invalid request.');
            return redirect()->route('all.users'); 
        } 
    }
    
    protected function rules()
    {
        $rules = [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'phone' => 'required|unique:users,phone,' . $this->id,
        ];
        if (!$this->id) {
            $rules['password'] = 'required|min:5|max:45|required_with:password_confirmation|same:password_confirmation';
            $rules['password_confirmation'] = 'required';
        } else {
            $rules['password'] = 'nullable|min:5|max:45|required_with:password_confirmation|same:password_confirmation';
            $rules['password_confirmation'] = 'nullable|required_with:password';
        }
        return $rules;
    }
    
    public function updatedPhone()
    {
        $this->dispatch('inputReset');
    }
    public function submit()
    {
        $this->dispatch('inputReset');
        $validatedData = $this->validate();
     
        $data = $this->except(['password']);
        if ($this->id) {
            $this->recordRow->fill($data);
            if (!empty($this->password)) {
                $this->recordRow->password =  Hash::make($this->password);
            }
            $this->recordRow->save();
           
            $msg = 'User updated successfully';
        } else {
            $data['password'] = Hash::make($this->password);
            $this->recordRow = User::create($data); 
            $msg = 'User added successfully';
        }
        foreach ($this->keywordTitle as $key => $titleValue) {
            $edit_keyword_id =  isset($this->keywordIds[$key])?$this->keywordIds[$key]:0;;
          
            if(!empty($edit_keyword_id)){
                $keyword = Keyword::findOrFail($edit_keyword_id);
            }else{
                $keyword = Keyword::where('keywordTitle', $titleValue)->first();
            }
           
            if ($keyword) {
                $keywordId = $keyword->id;  
                $keyword->update(['keywordTitle' => $titleValue]);
            } else {
           
                $keyword = Keyword::create(['keywordTitle' => $titleValue]);
                $keywordId = $keyword->id;  
            }
            UserKeyword::updateOrCreate(
                ['userId' => $this->recordRow->id, 'keywordId' => $keywordId],
                ['userId' => $this->recordRow->id, 'keywordId' => $keywordId]
            );
        }

       
        if (!empty($this->deletedKeywordIds)) {
            UserKeyword::where('userId', $this->recordRow->id)
                ->whereIn('keywordId', $this->deletedKeywordIds)
                ->delete();
            
            // Optionally, delete the keyword from the keywords table if no longer associated with any user
            Keyword::whereIn('id', $this->deletedKeywordIds)->delete();
        }
     
     
        return redirect()->route('all.users')->with('success',  $msg );

    }
    public function render()
    {
        return view('livewire.backend.users.user-manager');
    }
}
