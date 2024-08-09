=========================================
Example:
=========================================

use Illuminate\Support\Facades\Redirect;

$url = Redirect::getSecondLastUrl();

if ($url) {
    // Use the second-to-last URL
} else {
    // Handle the case where the second-to-last URL does not exist
}
