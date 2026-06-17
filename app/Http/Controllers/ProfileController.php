namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator; // Importa il Validator

class ProfileController extends Controller {
    
    public function showProfile() {
        return view('profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request) {
        $user = Auth::user();

        // Validator manuale (stile prof)
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'username' => 'required|unique:users,username,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        if ($validator->fails()) {
            return view('profile', ['user' => $user, 'error' => $validator->errors()->all()]);
        }

        // Aggiornamento
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->username = $request->username;
        $user->email = $request->email;

        // Gestione password opzionale
        if ($request->filled('password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return view('profile', ['user' => $user, 'error' => ['Vecchia password errata']]);
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return view('profile', ['user' => $user, 'success' => 'Profilo aggiornato con successo!']);
    }
}