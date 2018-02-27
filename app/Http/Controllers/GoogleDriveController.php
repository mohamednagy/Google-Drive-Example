<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserFile;

class GoogleDriveController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = app('GDClient');
    }
    public function callback(Request $request)
    {
        $this->client->authenticate($request->code);
        $tokens = $this->client->getAccessToken();

        auth()->user()->update([
            'gd_tokens'  => $tokens
        ]);

        return redirect('/home');
    }

    public function loadFiles()
    {
        $this->client->setAccessToken(auth()->user()->gd_tokens);

        if ($this->client->isAccessTokenExpired()) {
            $this->client->refreshToken(auth()->user()->gd_tokens['refresh_token']);

            $tokens = $this->client->getAccessToken();

            auth()->user()->update([
                'gd_tokens'  => $tokens
            ]);
        }

        $drive = new \Google_Service_Drive($this->client);

        $totalFiles = [];
        $pageToken = null;

        try {
            do {
            
                $params = $pageToken ? ['pageToken' => $pageToken] : [];
                $params['fields']   = 'files(id, name, mimeType, size, webContentLink)';
                $params['pageSize'] = 100;

                $files = $drive->files->listFiles($params);

                foreach ($files->getFiles() as $file) {
                    $fileMetaData = [
                        'file_id'       => $file->id,
                        'title'         => $file->name,
                        'mime_type'     => $file->mimeType,
                        'download_url'  => $file->webContentLink,
                        'size'          => $file->size != null ? ($file->size / 1024) : null,
                        'user_id'       => auth()->user()->id
                    ];
    
                    $totalFiles[] = $fileMetaData;
                }
                
                $pageToken = $files->getNextPageToken();
            } while($pageToken);

            auth()->user()->updateFiles($totalFiles);
        } catch(\Exception $e) {
            session()->flash('error' ,$e->getMessage());    
        }

        return redirect('/home');
    }
}
