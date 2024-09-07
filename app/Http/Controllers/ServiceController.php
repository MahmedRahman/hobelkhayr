<?php
namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     */
    public function index(Request $request)
    {


        $services = Service::all();



        return view('admin.pages.service.index', ['services' => $services]);

        // return response()->json($services);
    }

    /**
     * Store a newly created service in storage.
     */

    public function store(Request $request)
    {
        ob_end_clean();

        // Validate the request
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048', // Updated validation for image
        ]);

        try {
            // Handle the file upload
            if ($request->hasFile('service_image')) {

                $image = $request->file('service_image');
                $imagePath = $image->store('images', 'public'); // Store the image in the 'public/images' directory




            } else {
                $imagePath = null;
            }

            // Create the service
            $service = Service::create([
                'service_name' => $request->input('service_name'),
                'service_image' => asset(env('APP_URL')) . '/public/storage/' . $imagePath,
            ]);

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Service created successfully!', 'service' => $service]);
            }

            return redirect()->route('services.index')->with('success', 'Service added successfully!');

        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Failed to create service!'], 500);
            }

            return redirect()->back()->with('error', 'Failed to create service!');
        }
    }




    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        // Validate the request
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle the file upload if provided
        if ($request->hasFile('service_image')) {
            $imagePath = $request->file('service_image')->store('services', 'public');
            $service->service_image = $imagePath;
        }

        // Update the service
        $service->service_name = $request->input('service_name');
        $service->save();

        return response()->json(['message' => 'Service updated successfully!', 'service' => $service]);
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy($id, Request $request)
    {
        try {
            $service = Service::findOrFail($id);
            $service->delete();

            if ($request->wantsJson()) {
                return response()->json(['message' => 'Service deleted successfully!']);
            }

            return redirect()->back()->with('success', 'Service deleted successfully!');

        } catch (Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Service not found!'], 404);
            }

            return redirect()->back()->with('error', 'Service not found!');
        }
    }



}