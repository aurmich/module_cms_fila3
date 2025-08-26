pipeline {
    agent any
    environment {
        AWS_REGION = 'eu-west-1'
        INSTANCE_ID = 'i-06de104551729bd9f'
        SCRIPT_PATH = '/var/www/saluteorale/deploy.sh'
<<<<<<< HEAD
<<<<<<< HEAD
        GITLAB_TOKEN_ID = 'gitlab-access-token-saluteorale'
=======
>>>>>>> baf99f0f (Add Jenkinsfile)
=======
        GITLAB_TOKEN_ID = 'gitlab-access-token-saluteorale'
>>>>>>> 95c2f3ab (Update Jenkinsfile)
        MAX_WAIT_TIME = '300' // Come stringa per evitare problemi di cast
        POLL_INTERVAL = '5'  // Come stringa per evitare problemi di cast
        EMAIL_TO = 'g.casati@exabytesrl.it,m.sottana@exabytesrl.it'
    }
    stages {
        stage('Lancio script di deploy') {
            steps {
                script {
                    withAWS(credentials: 'aws-jenkins', region: env.AWS_REGION) {
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 95c2f3ab (Update Jenkinsfile)
                        withCredentials([usernamePassword(credentialsId: env.GITLAB_TOKEN_ID, usernameVariable: 'GIT_USERNAME', passwordVariable: 'GITLAB_TOKEN')]) {
                            // inizializza variabili per il polling
                            def status = "InProgress"
                            def startTime = System.currentTimeMillis()
                            def elapsedTime = 0
<<<<<<< HEAD

                            def command = "GITLAB_TOKEN=${GITLAB_TOKEN} ${SCRIPT_PATH}"

                            // esegui il comando ssm e cattura il CommandId
                            commandId = sh(
                                script: """
                                    aws ssm send-command \
                                        --region ${AWS_REGION} \
                                        --instance-ids ${INSTANCE_ID} \
                                        --document-name "AWS-RunShellScript" \
                                        --parameters 'commands=["${command}"]' \
                                        --output text \
                                        --query 'Command.CommandId'
                                """,
                                returnStdout: true
                            ).trim()
                            echo "Comando SSM inviato, CommandId: ${commandId}"

                            // converti le variabili d'ambiente in interi
                            int maxWaitTimeMs = env.MAX_WAIT_TIME.toInteger() * 1000
                            int pollIntervalSec = env.POLL_INTERVAL.toInteger()

                            // esegui il polling fino a quando il comando non è completato o scade il timeout
                            while (status == "InProgress" && elapsedTime < maxWaitTimeMs) {
                                sleep(time: pollIntervalSec, unit: 'SECONDS')

                                // recupera lo stato del comando
                                status = sh(
                                    script: """
                                        aws ssm get-command-invocation \
                                            --command-id ${commandId} \
                                            --instance-id ${INSTANCE_ID} \
                                            --query 'Status' \
                                            --output text
                                    """,
                                    returnStdout: true
                                ).trim()

                                // recupera lo standard output del comando
                                env.SCRIPT_STDOUT = sh(
                                    script: """
                                        aws ssm get-command-invocation \
                                            --command-id ${commandId} \
                                            --instance-id ${INSTANCE_ID} \
                                            --query 'StandardOutputContent' \
                                            --output text
                                    """,
                                    returnStdout: true
                                ).trim()

                                // recupera lo standard error del comando
                                env.SCRIPT_STDERR = sh(
                                    script: """
                                        aws ssm get-command-invocation \
                                            --command-id ${commandId} \
                                            --instance-id ${INSTANCE_ID} \
                                            --query 'StandardErrorContent' \
                                            --output text
                                    """,
                                    returnStdout: true
                                ).trim()

                                elapsedTime = System.currentTimeMillis() - startTime
                                echo "Stato comando: ${status}, Tempo trascorso: ${elapsedTime/1000} secondi"
                            }

                            // calcola il tempo totale trascorso e salvalo in una variabile d'ambiente
                            elapsedTime = System.currentTimeMillis() - startTime
                            env.ELAPSED_TIME = "${elapsedTime/1000}"

                            echo "Standard output dello script: ${env.SCRIPT_STDOUT}"
                            echo "Standard error dello script: ${env.SCRIPT_STDERR}"

                            // gestione timeout
                            if (status == "InProgress") {
                                env.ERROR_MESSAGE = "Deploy fallito: timeout raggiunto dopo ${env.MAX_WAIT_TIME} secondi"
                                error(env.ERROR_MESSAGE)
                            }
                            // gestione fallimento del comando ssm
                            else if (status == "Failed") {
                                env.ERROR_MESSAGE = "Deploy fallito: il comando SSM è terminato con stato 'Failed'."
                                error(env.ERROR_MESSAGE)
                            }
                            // gestione standard output che non termina con DEPLOY_SUCCESS
                            else if (!env.SCRIPT_STDOUT.endsWith("DEPLOY_SUCCESS")) {
                                env.ERROR_MESSAGE = "Deploy fallito: Lo standard output dello script non termina con 'DEPLOY_SUCCESS'."
                                error(env.ERROR_MESSAGE)
                            }
                            // tutto ok
                            else {
                                env.ERROR_MESSAGE = ""
                                echo "Deploy completato con successo!"
                            }
=======
                        def command = "bash ${SCRIPT_PATH}"
                        
                        // esegui il comando ssm e cattura il CommandId
                        def commandId = sh(
                            script: """
                                aws ssm send-command \
                                    --region ${AWS_REGION} \
                                    --instance-ids ${INSTANCE_ID} \
                                    --document-name "AWS-RunShellScript" \
                                    --parameters 'commands=${command}' \
                                    --output text \
                                    --query 'Command.CommandId'
                            """,
                            returnStdout: true
                        ).trim()
                        
                        echo "Comando SSM inviato, CommandId: ${commandId}"
                        
                        // inizializza variabili per il polling
                        def status = "InProgress"
                        def startTime = System.currentTimeMillis()
                        def elapsedTime = 0
                        
                        // converti le variabili d'ambiente in interi
                        int maxWaitTimeMs = env.MAX_WAIT_TIME.toInteger() * 1000
                        int pollIntervalSec = env.POLL_INTERVAL.toInteger()
                        
                        // esegui il polling fino a quando il comando non è completato o scade il timeout
                        while (status == "InProgress" && elapsedTime < maxWaitTimeMs) {
                            sleep(time: pollIntervalSec, unit: 'SECONDS')
                            
                            // recupera lo stato del comando
                            status = sh(
                                script: """
                                    aws ssm get-command-invocation \
                                        --command-id ${commandId} \
                                        --instance-id ${INSTANCE_ID} \
                                        --query 'Status' \
                                        --output text
                                """,
                                returnStdout: true
                            ).trim()
=======
>>>>>>> 95c2f3ab (Update Jenkinsfile)

                            def command = "GITLAB_TOKEN=${GITLAB_TOKEN} ${SCRIPT_PATH}"

                            // esegui il comando ssm e cattura il CommandId
                            commandId = sh(
                                script: """
                                    aws ssm send-command \
                                        --region ${AWS_REGION} \
                                        --instance-ids ${INSTANCE_ID} \
                                        --document-name "AWS-RunShellScript" \
                                        --parameters 'commands=["${command}"]' \
                                        --output text \
                                        --query 'Command.CommandId'
                                """,
                                returnStdout: true
                            ).trim()
                            echo "Comando SSM inviato, CommandId: ${commandId}"

                            // converti le variabili d'ambiente in interi
                            int maxWaitTimeMs = env.MAX_WAIT_TIME.toInteger() * 1000
                            int pollIntervalSec = env.POLL_INTERVAL.toInteger()

                            // esegui il polling fino a quando il comando non è completato o scade il timeout
                            while (status == "InProgress" && elapsedTime < maxWaitTimeMs) {
                                sleep(time: pollIntervalSec, unit: 'SECONDS')

                                // recupera lo stato del comando
                                status = sh(
                                    script: """
                                        aws ssm get-command-invocation \
                                            --command-id ${commandId} \
                                            --instance-id ${INSTANCE_ID} \
                                            --query 'Status' \
                                            --output text
                                    """,
                                    returnStdout: true
                                ).trim()

                                // recupera lo standard output del comando
                                env.SCRIPT_STDOUT = sh(
                                    script: """
                                        aws ssm get-command-invocation \
                                            --command-id ${commandId} \
                                            --instance-id ${INSTANCE_ID} \
                                            --query 'StandardOutputContent' \
                                            --output text
                                    """,
                                    returnStdout: true
                                ).trim()

                                // recupera lo standard error del comando
                                env.SCRIPT_STDERR = sh(
                                    script: """
                                        aws ssm get-command-invocation \
                                            --command-id ${commandId} \
                                            --instance-id ${INSTANCE_ID} \
                                            --query 'StandardErrorContent' \
                                            --output text
                                    """,
                                    returnStdout: true
                                ).trim()

                                elapsedTime = System.currentTimeMillis() - startTime
                                echo "Stato comando: ${status}, Tempo trascorso: ${elapsedTime/1000} secondi"
                            }

                            // calcola il tempo totale trascorso e salvalo in una variabile d'ambiente
                            elapsedTime = System.currentTimeMillis() - startTime
                            env.ELAPSED_TIME = "${elapsedTime/1000}"

<<<<<<< HEAD
                        echo "Standard output dello script: ${env.SCRIPT_STDOUT}"
                        echo "Standard error dello script: ${env.SCRIPT_STDERR}"
                        
                        // gestione timeout
                        if (status == "InProgress") {
                            echo "Timeout raggiunto: il comando non è stato completato entro ${env.MAX_WAIT_TIME} secondi"
                            env.ERROR_MESSAGE = "Deploy fallito: timeout raggiunto dopo ${env.MAX_WAIT_TIME} secondi"
                            error(env.ERROR_MESSAGE)
                        }
                        // gestione fallimento del comando ssm
                        else if (status == "Failed") {
                            env.ERROR_MESSAGE = "Deploy fallito: il comando SSM è terminato con stato 'Failed'."
                            error(env.ERROR_MESSAGE)
                        }
                        // gestione standard output che non termina con DEPLOY_SUCCESS
                        else if (!env.SCRIPT_STDOUT.endsWith("DEPLOY_SUCCESS")) {
                            env.ERROR_MESSAGE = "Deploy fallito: Lo standard output dello script non termina con 'DEPLOY_SUCCESS'."
                            error(env.ERROR_MESSAGE)
                        }
                        // tutto ok
                        else {
                            env.ERROR_MESSAGE = ""
                            echo "Deploy completato con successo!"
>>>>>>> baf99f0f (Add Jenkinsfile)
=======
                            echo "Standard output dello script: ${env.SCRIPT_STDOUT}"
                            echo "Standard error dello script: ${env.SCRIPT_STDERR}"

                            // gestione timeout
                            if (status == "InProgress") {
                                echo "Timeout raggiunto: il comando non è stato completato entro ${env.MAX_WAIT_TIME} secondi"
                                env.ERROR_MESSAGE = "Deploy fallito: timeout raggiunto dopo ${env.MAX_WAIT_TIME} secondi"
                                error(env.ERROR_MESSAGE)
                            }
                            // gestione fallimento del comando ssm
                            else if (status == "Failed") {
                                env.ERROR_MESSAGE = "Deploy fallito: il comando SSM è terminato con stato 'Failed'."
                                error(env.ERROR_MESSAGE)
                            }
                            // gestione standard output che non termina con DEPLOY_SUCCESS
                            else if (!env.SCRIPT_STDOUT.endsWith("DEPLOY_SUCCESS")) {
                                env.ERROR_MESSAGE = "Deploy fallito: Lo standard output dello script non termina con 'DEPLOY_SUCCESS'."
                                error(env.ERROR_MESSAGE)
                            }
                            // tutto ok
                            else {
                                env.ERROR_MESSAGE = ""
                                echo "Deploy completato con successo!"
                            }
>>>>>>> 95c2f3ab (Update Jenkinsfile)
                        }
                    }
                }
            }
        }
    }
    post {
        always {
            script {
                def subjectResult = currentBuild.result == 'FAILURE' ? 'fallito' : 'eseguito'
                def contentResult = currentBuild.result == 'FAILURE' ? 'fallito' : 'stato eseguito con successo'

                echo "Invio mail a ${env.EMAIL_TO}"

                def formattedErrorMessage = env.ERROR_MESSAGE ? env.ERROR_MESSAGE.replaceAll('(\r\n|\r|\n)', '<br/>') : '-'
                def formattedScriptStdOut = env.SCRIPT_STDOUT ? env.SCRIPT_STDOUT.replaceAll('(\r\n|\r|\n)', '<br/>') : '-'
                def formattedScriptStdErr = env.SCRIPT_STDERR ? env.SCRIPT_STDERR.replaceAll('(\r\n|\r|\n)', '<br/>') : '-'

                emailext(
                    subject: "Deploy ${subjectResult} per ${env.JOB_NAME} #${env.BUILD_NUMBER}",
                    body: """
                        Il deploy è ${contentResult} per il progetto <b>${env.JOB_NAME}</b>.
<<<<<<< HEAD
<<<<<<< HEAD

                        <br/><br/><b>URL:</b>
                        <br/>${env.BUILD_URL}

=======
                        
                        <br/><br/><b>URL:</b>
                        <br/>${env.BUILD_URL}
                        
>>>>>>> baf99f0f (Add Jenkinsfile)
=======

                        <br/><br/><b>URL:</b>
                        <br/>${env.BUILD_URL}

>>>>>>> 95c2f3ab (Update Jenkinsfile)
                        <br/><br/><b>Tempo di esecuzione:</b>
                        <br/>${env.ELAPSED_TIME} secondi

                        <br/><br/><b>Errore:</b>
                        <br/>${formattedErrorMessage}
<<<<<<< HEAD
<<<<<<< HEAD

=======
                        
>>>>>>> baf99f0f (Add Jenkinsfile)
=======

>>>>>>> 95c2f3ab (Update Jenkinsfile)
                        <br/><br/><b>Standard output dello script:</b>
                        <br/>${formattedScriptStdOut}

                        <br/><br/><b>Standard error dello script:</b>
                        <br/>${formattedScriptStdErr}
                    """,
                    to: env.EMAIL_TO,
                    from: "jenkins@jenkins.exacloud.it"
                )
            }
        }
<<<<<<< HEAD
=======
        success {
            echo 'Deploy completato con successo!'
        }
        failure {
            echo 'Deploy fallito!'
        }
>>>>>>> baf99f0f (Add Jenkinsfile)
    }
}
