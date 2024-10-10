<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Kreait\Firebase\Factory;
use Illuminate\Http\Request;

class FirestoreController extends Controller
{
    protected $firestore;

    public function __construct()
    {


        // Firebase credentials as an array
        $firebaseCredentials = [
            "type" => "service_account",
            "project_id" => "chat-app-64bd1",
            "private_key_id" => "450d8aa85cefa3ee6a09b9f559e0969b280c4373",
            "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCvrbYzol0PZZ7+\n4C9lm9QI9RGRORdOHCReU+eRUmeTret0yf7W8WXhr8FdWDdWl9sNlo5YxxIMrxmF\nLFtDcQ4jNplqfopvAPIm8GABBj4uy3UMy8jxLp4uPu6ghIiMQwlzYT/C5H7wSOPr\nc3jqOTp9BD0XCdphTFh5iPIHIUbPIbOoRI0lDm8SuGcKE4HXJu9D3G1tWuj4UyjA\nzLcIsoQVXtPVSwNFEMW+L/zQjCrJVpr8tyJhH2Tv2GT3oOHYl+Uc6iwhL+AvAHe9\ncRz+yqNgUHHXqcm9ApV+NKrGrQJMTSVTDPIDDmUhr9WfOGHwsi2nW+eU60MSFCD1\naunwh/JLAgMBAAECggEAV2KKCf8OWTVMNC2hheJQQzBbz6fdTs4yzPThb+jUeqH9\nR/eeGp6y9eLtxRe3VwxsOsMUBVboRITopdSdhNt8k8l54H4XMAYBbZsNthS745zy\nmS3YwxdUOV62ZgPmxBYoYksSY0gzWCR5ssmacK+Mx1jPZmFRTiqiq7mR4jgMN8UR\n0SxcNMSHSUtQqN3CqoiGkWQDOhktYQKZcAEVkYP2GRMHcI6cnZX37imTCAmMppev\nVsh7lIAVgxhB01IfYiumOyCR6BopMhq1LW0PsaC5mGzROdSvZSCGV6FKeWMFnFmX\n0a9GQFgj1Af8o1Ddmq0KVkKEmi+xHlKzDURcEJ6xWQKBgQDWx36GNF4clHfuzpVa\nLO1t1OwijvjQ5LRkJMeqH7HBTDF9K3pSOJHzYlbDsg8UhYMR3SPzo6YFvThmczSh\n0Jed1DXysi2HrmPSnlO5Ls1JBg3SdCDRdzlwhVs7hYwXj/hcIfpqbDTZ/eLVEZPX\neOuVCTsuxGiEpA5NQAxp+yBe5wKBgQDRZSBrhz2g9DL+iHLrxI3io3J1fnCcSc5a\nisU7gVLP5GkKdgg4BEzVU4EygooF+AbI7OCaO25YnZOqZjR09UuD0RKsEQQcPILs\nmTgg4Dv2kjetow0CJzTuWGpYX5AbjAicRzeUotaW5PptMHiEgNE+pr5jQiQu+JUi\nKwcFzCeY/QKBgQCEuxKo83H5rZMUpNxNtxgf2Qb5MGv6BGyqusQdkaqzb1fiJ91X\nNJiV1X8TP1Xsc7oVbxmJtueiAlb5kVbEbXlVU1DnpE9Y21/bSHcrKQ46g6BFH/ks\nGccIj5FbDmQOJ63vmhv8atSapzjoPg2kipjkKKlHdJ+24P/po5xIXqaZnwKBgQC1\nNHhL1WtFwE3o6xfYY+4NNTi16Md22IAU5oYsKowJkDY+cUpHf6El8u+ZUFI1PCBS\n/HqZvdiOIz9IdM3scOH6npE0Cj2uWcdLDIUAHkyF4p8ASlvVgyxRHn5ZH8nLrPE+\nnHrCy/A8AMeeehWxRPDO8OlNaE17wG7+dJHNOJED2QKBgBMFW4EuTjDa4QhrO4SF\nOkga55HOR3AJrkmiNsCAVKyn8loWQ3baHgYxkzALwjwuYPSkCXHSDo8+bGGGjMW6\nC4+//2dUnJEM+jhOq9qDbOTsjEsYs+yLQvxXqC+jdNXpRXjZP8p2ApbVyyhmZdiX\n+D9juNqKvwTSRZ9CK8Ba3Ktf\n-----END PRIVATE KEY-----\n",
            "client_email" => "firebase-adminsdk-cm7gv@chat-app-64bd1.iam.gserviceaccount.com",
            "client_id" => "116784995105393587210",
            "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
            "token_uri" => "https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
            "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-cm7gv%40chat-app-64bd1.iam.gserviceaccount.com"
        ];
        // Initialize Firestore
        $this->firestore = (new Factory)
            ->withServiceAccount($firebaseCredentials)
            ->createFirestore()
            ->database();
    }

    public function addGroup(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'group_name' => 'required|string|max:255',
        ]);

        try {
            // Reference the chat_group collection
            $chatGroupCollection = $this->firestore->collection('chat_group');

            // Add a new document to the collection
            $newGroup = $chatGroupCollection->add([
                'group_name' => $validated['group_name'],
                'created_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Document added successfully!',
                'document_id' => $newGroup->id(),
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add document: ' . $e->getMessage(),
            ], 500);
        }
    }
}