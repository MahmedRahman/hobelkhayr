<?php
namespace App\Http\Controllers;
use Exception;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the services.
     */
    public function index(Request $request)
    {
        $services = Service::all();
        return view('admin.pages.service.index', ['services' => $services]);
    }

    /**
     * Store a newly created service in storage.
     */

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048', // Updated validation for image
        ]);

        try {
            // Handle the file upload
            if ($request->hasFile('service_image')) {
                $image = $request->file('service_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/services'), $imageName);
                $imagePath = 'uploads/services/' . $imageName;
            }

            Service::create([
                'service_name' => $request->service_name,
                'service_image' => $imagePath ?? null,
            ]);

            return redirect()->route('services.index')->with('success', 'Service added successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to create service: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update the specified service in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        try {
            $service = Service::findOrFail($id);
            
            // Handle image upload if new image is provided
            if ($request->hasFile('service_image')) {
                // Delete old image if exists
                if ($service->service_image && file_exists(public_path($service->service_image))) {
                    unlink(public_path($service->service_image));
                }

                // Upload new image
                $image = $request->file('service_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/services'), $imageName);
                $service->service_image = 'uploads/services/' . $imageName;
            }

            // Update service name
            $service->service_name = $request->service_name;
            $service->save();

            return redirect()->route('services.index')
                ->with('success', 'Service updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update service: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy($id)
    {
        try {
            $service = Service::findOrFail($id);
            
            // Delete image if exists
            if ($service->service_image && file_exists(public_path($service->service_image))) {
                unlink(public_path($service->service_image));
            }
            
            $service->delete();
            return redirect()->back()->with('success', 'Service deleted successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete service: ' . $e->getMessage());
        }
    }
}