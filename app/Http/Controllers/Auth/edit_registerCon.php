    public function store(Request $request)
    {
        if ($request['user_status_id'] == 3) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:30'],
            'tell' => ['required', 'string', 'max:10'],
            'school_name' => ['required', 'string', 'max:255'],
            'school_Detail' => ['required', 'string', 'max:255'],
            'Address_hn' => ['required', 'string', 'max:10'],
            'Address_m' => ['required', 'string', 'max:255'],
            'Address_t' => ['required', 'string', 'max:255'],
            'Address_a' => ['required', 'string', 'max:255'],
            'Address_j' => ['required', 'string', 'max:255'],
            'Address_p' => ['required', 'string', 'max:6'],
            'school_tell' => ['required', 'string', 'max:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:managers'],
            'user_status_id' => ['required', 'string', 'max:10'],
        ]);

       $post = new manager;
       $post->name = $request->input('name');
       $post->surname = $request->input('surname');
       $post->gender = $request->input('gender');
       $post->tell = $request->input('tell');
       $post->school_name = $request->input('school_name');
       $post->Address_hn = $request->input('Address_hn');
       $post->address_m = $request->input('address_m');
       $post->Address_t = $request->input('Address_t');
       $post->Address_a = $request->input('Address_a');
       $post->Address_j = $request->input('Address_j');
       $post->address_p = $request->input('address_p');
       $post->Address_p = $request->input('Address_p');
       $post->school_tell = $request->input('school_tell');
       $post->email = $request->input('email');
       $post->password = Hash::make($request->input('password'));
       $post->user_status_id = $request->input('user_status_id');
       /*if   ($request->file('profile_image')) {
           $file=$request->file('profile_image');
           $filename = time().'_'.$file->getClientOriginalExtension();
           $request->profile_image->move('storage/member_assets',$filename);
           $post->profile_image =$filename; 
           
       } */
       //dd($post);
       $post->save();
       return redirect('/manager');
        }
        else if ($request['user_status_id'] == 2) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'surname' => ['required', 'string', 'max:255'],
                'gender' => ['required', 'string', 'max:30'],
                'tell' => ['required', 'string', 'max:10'],
                'status' => ['required', 'string', 'max:50'],
                'manager_id' => ['required', 'string', 'max:10'],
                'card_id' => ['required', 'string', 'max:13'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:tutors'],
                'user_status_id' => ['required', 'string', 'max:10'],
            ]);
    
           $post = new tutor;
           $post->name = $request->input('name');
           $post->surname = $request->input('surname');
           $post->gender = $request->input('gender');
           $post->tell = $request->input('tell');
           $post->status = $request->input('status');
           $post->manager_id = $request->input('manager_id');
           $post->card_id = $request->input('card_id');
           $post->email = $request->input('email');
           $post->password = Hash::make($request->input('password'));
           $post->user_status_id = $request->input('user_status_id');
           /*if   ($request->file('profile_image')) {
               $file=$request->file('profile_image');
               $filename = time().'_'.$file->getClientOriginalExtension();
               $request->profile_image->move('storage/member_assets',$filename);
               $post->profile_image =$filename; 
               
           } */
           //dd($post);
           $post->save();
           return redirect('/manager');
        }
        else if ($request['user_status_id'] == 1) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'surname' => ['required', 'string', 'max:255'],
                'gender' => ['required', 'string', 'max:30'],
                'tell' => ['required', 'string', 'max:10'],
                'manager_id' => ['required', 'string', 'max:10'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:tutors'],
                'user_status_id' => ['required', 'string', 'max:10'],
            ]);
    
           $post = new tutor;
           $post->name = $request->input('name');
           $post->surname = $request->input('surname');
           $post->gender = $request->input('gender');
           $post->tell = $request->input('tell');
           $post->manager_id = $request->input('manager_id');
           $post->email = $request->input('email');
           $post->password = Hash::make($request->input('password'));
           $post->user_status_id = $request->input('user_status_id');
           /*if   ($request->file('profile_image')) {
               $file=$request->file('profile_image');
               $filename = time().'_'.$file->getClientOriginalExtension();
               $request->profile_image->move('storage/member_assets',$filename);
               $post->profile_image =$filename; 
               
           } */
           //dd($post);
           $post->save();
           return redirect('/student');
        }
    }

    protected function validator(array $data)
    {
        if ($data['user_status_id'] == 1) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:30'],
            'tell' => ['required', 'string', 'max:10'],
            'school_name' => ['required', 'string', 'max:255'],
            'school_Detail' => ['required', 'string', 'max:255'],
            'Address_hn' => ['required', 'string', 'max:10'],
            'Address_m' => ['required', 'string', 'max:255'],
            'Address_t' => ['required', 'string', 'max:255'],
            'Address_a' => ['required', 'string', 'max:255'],
            'Address_j' => ['required', 'string', 'max:255'],
            'Address_p' => ['required', 'string', 'max:6'],
            'school_tell' => ['required', 'string', 'max:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:managers'],
            'user_status_id' => ['required', 'string', 'max:10'],
        ]);
    }
    if ($data['user_status_id'] == 2) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'tell' => ['required', 'string', 'max:10'],
            'status' => ['required', 'string', 'max:50'],
            'manager_id' => ['required', 'string', 'max:10'],
            'card_id' => ['required', 'string', 'max:13'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:tutor'],
            'user_status_id' => ['required', 'string', 'max:10'],
        ]);
    }
    if ($data['user_status_id'] == 3) {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'tell' => ['required', 'string', 'max:255'],
            'manager_id' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:students'],
            'user_status_id' => ['required', 'string', 'max:10'],
        ]);
    }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if ($data['user_status_id']==1) {
        Return  manager::create([
                'email' => $data['email'],
                'password' => Hash::make($data['tell']),
                'name' => $data['name'],
                'surname' => $data['surname'],
                'gender' => $data['gender'],
                'tell' => $data['tell'],
                'school_name' => $data['school_name'],
                'school_Detail' => $data['school_Detail'],
                'Address_hn' => $data['Address_hn'],
                'Address_m' => $data['Address_m'],
                'Address_t' => $data['Address_t'],
                'Address_a' => $data['Address_a'],
                'Address_j' => $data['Address_j'],
                'Address_p' => $data['Address_p'],
                'school_tell' => $data['school_tell'],
                'user_status_id' => $data['user_status_id'],
                 ]);
        }
      elseif ($data['user_status_id'] == 2) {
        Return  tutor::create([
                'email' => $data['email'],
                'password' => Hash::make($data['tell']),
                'name' => $data['name'],
                'surname' => $data['surname'],
                'gender' => $data['gender'],
                'tell' => $data['tell'],
                'status' => $data['status'],
                'manager_id' => $data['manager_id'],
                'card_id' => $data['card_id'],
                'user_status_id' => $data['user_status_id'],
                ]);
      }
      elseif ($data['user_status_id'] == 3) {
        Return  student::create([
                'email' => $data['email'],
                'password' => Hash::make($data['tell']),
                'name' => $data['name'],
                'surname' => $data['surname'],
                'gender' => $data['gender'],
                'tell' => $data['tell'],
                'manager_id' => $data['manager_id'],
                'user_status_id' => $data['user_status_id'],
                ]);
        }
    }