
        <table border="1" cellpadding="0" cellspacing="0">
            <tbody>
            @if($questionsRegistration)
                <tr>
                    <th colspan="3">Регистрациоонная анкета</th>
                </tr>
                @foreach($questionsRegistration as $question)
                    @if($question->type_id == 3 || $question->type_id == 4 || $question->type_id == 5)

                        <tr>
                            <th colspan="3">{{$question->name}}</th>
                        </tr>
                        <tr>
                            <th>Вариант ответа</th>
                            <th>Количество</th>
                        </tr>
                        @foreach($question->options as $child)
                            @if($child->rus_lang_id == 0)
                                <tr>
                                    <td>{{$child->name}}</td>
                                    <td>{{$child->answers->groupBy( 'project_request_id')->count()}}</td>
                                </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <th colspan="3">Итоговая анкета</th>
                </tr>
            @endif

            @foreach($questions as $question)
                @if($question->type_id == 3 || $question->type_id == 4 || $question->type_id == 5)

            <tr>
                <th colspan="3">{{$question->name}}</th>
            </tr>
            <tr>
                <th>Вариант ответа</th>
                <th>Количество</th>
            </tr>
                @foreach($question->options as $child)
                    @if($child->rus_lang_id == 0)
                        <tr>
                            <td>{{$child->name}}</td>
                            <td>{{$child->answers->groupBy( 'project_request_id')->count()}}</td>
                        </tr>
                    @endif
                @endforeach
            <tr>
                <td></td>
            </tr>
            <tr>
                <td></td>
            </tr>
                @endif
            @endforeach
            </tbody>
        </table>
