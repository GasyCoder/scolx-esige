            <!-- Quick Post -->
            <div class="card p-5">
                <div class="mt-0">
                  {{ Form::open(['route'=>'admin_notes_store', 'id'=>'add-note'])  }}
                        <div class="mb-5">
                            <label class="label block mb-2" for="content">Contenus</label>
                            <textarea name="note" id="content" class="form-control" rows="4" required placeholder="Saisir votre mémoire"></textarea>
                        </div>
                        <div class="mb-5">
                            <label class="label block mb-2" for="category">Catégories</label>
                            <div class="custom-select">
                                <select name="priority" class="form-control">
                                    <option value="" selected disabled>--Choisir--</option>
                                    <option value="Urgent">Urgent</option>
                                    <option value="Intéressant">Intéressant</option>
                                    <option value="Archive">Pour archive</option>
                                </select>
                                <div class="custom-select-icon la la-caret-down"></div>
                            </div>
                        </div>
                        <div class="mt-10">
                            <button class="btn btn_primary">Partager</button>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>