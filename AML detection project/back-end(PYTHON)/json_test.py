import json
import web
import shutil
import os
import numpy as np
import pandas as pd
import tensorflow as tf
from tensorflow import keras
from sklearn.preprocessing import LabelEncoder, OneHotEncoder
from sklearn.compose import ColumnTransformer

os.environ['TF_CPP_MIN_LOG_LEVEL'] = '2'
model = tf.keras.models.load_model('model')

from cheroot.server import HTTPServer
from cheroot.ssl.builtin import BuiltinSSLAdapter

HTTPServer.ssl_adapter = BuiltinSSLAdapter(
        certificate='/Git/FinTech/cert/certificate.crt',
        private_key='/Git/FinTech/cert/private.key')


def returnCheck():

	str = {"idx":"6"},{"idx":"37"},{"idx":"8"},{"idx":"34"},{"idx":"28"}
	
	return json.dumps(str)
	
class Processdata():
    def __init__(self, file):
        self.file = pd.read_csv(file)
        
    def processdata(self):
        processfile = self.file.drop('nameOrig',axis = 1,inplace = False).drop('nameDest',axis = 1,inplace = False).drop('isFlaggedFraud',axis = 1,inplace = False)
        processfile = np.array(processfile)
        labelencoder = LabelEncoder()
        processfile[:, 2] = labelencoder.fit_transform(processfile[:, 2])
        processfile =  processfile[:,1:]
        processfile[:, 0] = (processfile[:, 0]-243.39724563151657)/142.3319598641272
        processfile[:, 1] = (processfile[:, 1]-1.714149988526739)/1.3501164688076697
        processfile[:, 2] = (processfile[:, 2]-179861.90354912292)/603858.1840094082
        processfile[:, 3] = (processfile[:, 3]-833883.1040744851)/2888242.4460370434
        processfile[:, 4] = (processfile[:, 4]-855113.6685785672)/2924048.273187338
        processfile[:, 5] = (processfile[:, 5]-1100701.6665196999)/3399179.845847952
        processfile[:, 6] = (processfile[:, 6]-1224996.3982020712)/3674128.6533661983
        processfile = np.asarray(processfile).astype(np.float32)
        return processfile
    
    def predict(self):
        prediction=model.predict(self.processdata())
        prediction = np.round(prediction)
        return prediction
    
    def into_csv(self):
        self.file['isFraud']=self.predict()
        return self.file
    
    def to_json(self):
        idx = self.into_csv()
        idx=idx[idx['isFraud']==1]['idx']
        idx=idx.tolist()
        idxlist=[]
        for i in range(len(idx)):
            idx_json = idx[i]
            idx_json = '{"idx":"'+str(idx_json)+'"}'
            idxlist.append(idx_json)
        return idxlist

	
	
urls = (
'/input', 'index'
)



class index:
	def GET(self):
		i = web.input(name=None)
		##return render.index(i.name)
		##return jsonReturn(i.name,i.name,i.name,i.name)
		a=Processdata('./test.csv')
		return a.to_json()
		#return returnCheck()
	def POST(self):
		j = web.input(key=None)
		if j.key=='2cqm7NLXkftJUqqajtCA5Euf3CkQfNFX':
			a=Processdata('./test.csv')
			#return json.dumps(a)
			return returnCheck()
		else:
			return 'Invalid request'
		#raise web.seeother('/input')   
		
		

if __name__ == "__main__":
	app = web.application(urls, globals())
	app.run()
render = web.template.render('templates/')


