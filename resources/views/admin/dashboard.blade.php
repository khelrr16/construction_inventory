@extends('layouts.admin.layout')

@section('title', 'Dashboard')

@section('content')

    <main class="content">
        <header>
            <h1>CONTRUCKTOR</h1>
            <p>Project Dashboard</p>
        </header>

        <div class="card-container">
            <div class="card">
                <div class="card-icon"><i class="fas fa-check-circle"></i></div>
                <div class="card-info">
                    <h3>12</h3>
                    <p>Completed Projects</p>
                </div>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fas fa-clock"></i></div>
                <div class="card-info">
                    <h3>5</h3>
                    <p>Pending Projects</p>
                </div>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fas fa-users"></i></div>
                <div class="card-info">
                    <h3>7</h3>
                    <p>Active Projects</p>
                </div>
            </div>
        </div>
    </main>


<div class="overlay" id="overlay"></div>

<div class="popup-container" id="createProjectPanel">
    <div class="panel-content">
        <h4><i class="fas fa-folder-plus"></i> New Project</h4>

        <label class="mt-3">Project Name</label>
        <input type="text" class="form-control" placeholder="Enter project name">

        <label class="mt-3">Project Description</label>
        <textarea class="form-control" rows="3" placeholder="Enter description"></textarea>

        <div class="d-flex justify-content-end mt-4">
            <button id="closePanelBtn" class="btn btn-light border me-2">Cancel</button>
            <button class="btn btn-success"><i class="fas fa-check-circle"></i> Save</button>
        </div>
    </div>
</div>
@endsection